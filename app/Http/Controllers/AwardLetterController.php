<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardLetterStoreRequest;
use App\Http\Requests\AwardLetterUpdateRequest;
use App\Http\Resources\AwardLetterCollection;
use App\Http\Resources\AwardLetterInternalDocumentCollection;
use App\Http\Resources\AwardLetterResource;
use App\Models\AwardLetter;
use App\Models\AwardLetterInternalDocument;
use App\Models\ContractDocumentSubmission;
use App\Models\ContractDocumentSubmissionEntry;
use App\Models\Employee;
use App\Models\Notification;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AwardLetterController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AwardLetterCollection
     */
    public function index(Request $request)
    {
        $awardLetters = AwardLetter::with('contractor', 'contractType', 'project', 'duration', 'bankReferences', 'approvedBy')->latest()->get();

        return new AwardLetterCollection($awardLetters);
    }

    /**
     * @param \App\Http\Requests\AwardLetterStoreRequest $request
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function store(AwardLetterStoreRequest $request)
    {
        $data = $request->validated();
        $data = $request->all();
        $currentApprover = Employee::where('is_approver', true)->first();
        if ($currentApprover == null) {
            // return response([
            //     'message'   => 'An approver has not been assigned. Please go to the Staff section to assign an Approver.'
            // ], Response::HTTP_BAD_REQUEST);
            throw new BadRequestException('An approver has not been assigned. Please go to the Staff section to assign an Approver.');
        }

        $lastAwardLetter = AwardLetter::latest('id')->first();
        $serial_no = $lastAwardLetter ? $lastAwardLetter->id + 1 : 1;
        $reference_no = "NCDMB/DLS/002/" . date('y') . "/" . $serial_no;
        // array_merge($data, [
        //     'serial_no' => $serial_no,
        //     'reference_no' => $reference_no,
        // ]);
        $data['approved_by'] = $currentApprover->id;
        $data['serial_no'] = $serial_no;
        $data['reference_no'] = $reference_no;
        Log::info($data);
        $awardLetter = new AwardLetter();
        DB::transaction(function () use ($data) {
            $awardLetter = AwardLetter::create($data);

            // Create Award Letter Submission
            $submission = ContractDocumentSubmission::create([
                'url_token'     => uniqid('cds_'),
                'access_code'   => Str::random(6),
                'award_letter_id'   => $awardLetter->id,
                'due_date'  => $data['document_submission_due_date']
            ]);

            foreach ($data['required_document_ids'] as $reqDocId) {
                ContractDocumentSubmissionEntry::create([
                    'entry_id'  => $submission->id,
                    'document_type_id' => $reqDocId,
                ]);
            }
        });


        // Create Submission Entries

        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = "Award Letter Created";
        $notification->content = "A new award letter with Reference No. : " . $awardLetter->reference_no . " was created by you on " . now() . ".";
        $notification->action_link = env("CLIENT_URL") . "/#/contracts/award-letters/history";
        $notification->save();

        $recipientEmail = auth()->user()->email;

        try {
            Mail::to($recipientEmail)->queue(new \App\Mail\AwardLetter($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }

        return new AwardLetterResource($awardLetter->load('duration', 'contractor', 'contractType', 'project', 'approvedBy'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetter $awardLetter
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function show(Request $request, AwardLetter $awardLetter)
    {
        return new AwardLetterResource($awardLetter->load('duration', 'bankReferences', 'contractor', 'contractType', 'project', 'approvedBy', 'contractDocumentSubmission', 'contractDocumentSubmission.entries'));
    }

    /**
     * @param \App\Http\Requests\AwardLetterUpdateRequest $request
     * @param \App\Models\AwardLetter $awardLetter
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function update(AwardLetterUpdateRequest $request, AwardLetter $awardLetter)
    {
        // Log::debug($request->validated());
        $awardLetter->update($request->validated());

        return new AwardLetterResource($awardLetter->load('duration', 'bankReferences', 'contractor', 'contractType', 'project', 'approvedBy', 'contractDocumentSubmission', 'contractDocumentSubmission.contractDocumentSubmissionEntries'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetter $awardLetter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AwardLetter $awardLetter)
    {
        $awardLetter->delete();

        return response()->noContent();
    }

    public function pending(Request $request)
    {
        $pendingAwardLetters = AwardLetter::doesntHave('bankReferences')->with('contractor', 'contractType', 'project', 'duration', 'approvedBy')->latest()->get();

        return new AwardLetterCollection($pendingAwardLetters->load('contractor', 'contractType', 'project', 'duration', 'approvedBy', 'bankReferences'));
    }

    public function awardLetterWithBankGuarantee(Request $request)
    {
        $awardLetterWithBankGaurantee = AwardLetter::with('contractor', 'contractType', 'project', 'duration', 'approvedBy', 'bankReferences')
            ->has('bankReferences')->get();

        return new AwardLetterCollection($awardLetterWithBankGaurantee);
    }

    public function awardLetterRenewals(Request $request)
    {
        $data = AwardLetter::where('last_bank_ref_date', '<', now())->orderBy('id', 'desc')->latest()->get();

        return new AwardLetterCollection($data->load('contractor', 'contractType', 'project', 'duration', 'approvedBy', 'bankReferences'));
    }

    public function checkRefNo(Request $request, string $refNo)
    {

        $exists = AwardLetter::where('reference_no', $refNo)->first();

        return $this->success($exists);
    }

    public function getInternalDocuments(int $id)
    {
        $documents = AwardLetterInternalDocument::where('award_letter_id', $id);

        return new AwardLetterInternalDocumentCollection($documents);
    }
}
