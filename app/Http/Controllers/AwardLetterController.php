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
use Illuminate\Support\Facades\Storage;
use NumberFormatter;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use PDF;
use Dompdf\Dompdf;

use function Psy\debug;

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
        // DB::transaction(function () use ($data) {
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
        // });

        Log::debug("Just Stored Award Letter");
        Log::debug($awardLetter);


        // Create Submission Entries

        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = "Award Letter Created";
        $notification->content = "A new award letter with Reference No. : " . $awardLetter->reference_no . " was created by you on " . now() . ".";
        $notification->action_link = env("CLIENT_URL") . "/#/contracts/award-letters/details/" . $awardLetter->id;
        $notification->save();

        $recipientEmail = auth()->user()->email;

        try {
            Mail::to($recipientEmail)->queue(new \App\Mail\AwardLetter($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }

        // $notification1 = new Notification();
        // // $notification->user_id = $awardLetter->contractor->user_id;
        // $notification->subject = "Required Documents for Award Letter";
        // $notification->content == "You are required to submit the following documents for the award letter with Reference No. : " . $awardLetter->reference_no . "." . "Document To be Submitted: "  . "Submission Due Date: " . $data['document_submission_due_date'] . "Submission Link: " . env("CLIENT_URL") . "/#/contractor-document-submission/" . $submission->url_token . " Access Code: " . $submission->access_code;
        // $notification->action_link = env("CLIENT_URL") . "/#/contractor-document-submission/" . $submission->url_token;
        // // $notification->save();

        $details = [
            'subject' => 'Required Documents for Award Letter',
            'content' => "You are required to submit the following documents for the award letter with Reference No. : " . $awardLetter->reference_no . ".",
            'action_link' => env("CLIENT_URL") . "/#/contractor-document-submission/" . $submission->url_token,
            'entries' => $awardLetter->contractDocumentSubmission->entries,
            'submission_date' => " Submission Due Date: " . $data['document_submission_due_date'],
            'submission_link' => "Submission Link: " . env("CLIENT_URL") . "/#/contractor-document-submission/" . $submission->url_token,
            'access_code' => " Access Code: " . $submission->access_code,
        ];

        info($details);

        $recipientEmail1 = $awardLetter->contractor->email;

        try {
            Mail::to($recipientEmail1)->queue(new \App\Mail\Contractor($details));
        } catch (Exception $e) {
            Log::debug($e);
        }

        $this->generateAwardLetter($awardLetter->id);

        return new AwardLetterResource($awardLetter->load('duration', 'contractor', 'contractType', 'project', 'approvedBy'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetter $awardLetter
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function show(Request $request, AwardLetter $awardLetter)
    {
        return new AwardLetterResource($awardLetter->load('duration', 'bankReferences', 'contractor', 'contractType', 'project', 'approvedBy', 'contractDocumentSubmission', 'contractDocumentSubmission.entries', 'contractDocumentSubmission.entries.contractDocumentType')); //, 'contractDocumentSubmission.entries'));
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

        return new AwardLetterResource($awardLetter->load('duration', 'bankReferences', 'contractor', 'contractType', 'project', 'approvedBy', 'contractDocumentSubmission', 'contractDocumentSubmission.entries'));
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
        $documents = AwardLetterInternalDocument::where('award_letter_id', $id)->latest()->get();

        return new AwardLetterInternalDocumentCollection($documents->load('postedBy'));
    }

    public function sendAwardLetter(Request $request, int $id)
    {
        $awardLetter = AwardLetter::findOrFail($id);

        $signature_file_path = storage_path('/app/public/files/' . $awardLetter->approvedBy->signature_file);

        Log::debug($signature_file_path);

        $recipient_emails = $request->recipient_emails;

        if (!empty($recipient_emails)) {
            $recipient_emails = explode(',', $recipient_emails);
        }

        $include_contractor = $request->include_contractor;

        if ($include_contractor == 'true') {
            $recipient_emails[] = $awardLetter->contractor->email;
        }

        $details = [
            'subject' => 'NOTIFICATION OF CONTRACT AWARD',
            'content' => "Award Letter with Reference No. : " . $awardLetter->reference_no . ".",
        ];


        $file_name = str_replace("/", "_", $awardLetter->reference_no . '.pdf');

        $file = storage_path('/app/public/award_letters/' . $file_name);
        $recipient_emails = array_unique($recipient_emails);

        try {
            info('Sending email to ' . implode(', ', $recipient_emails));
            Mail::to($recipient_emails)->queue(new \App\Mail\AwardLetterDoc($details, $file));
            info('sent');
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    public function htmlToPdf()
    {
        // return view('htmlView');

        // selecting PDF view
        $pdf = PDF::loadView('award_letter');

        $pdf->render();

        // download pdf file
        return $pdf->download('pdfview.pdf');
    }

    public function generateAwardLetter($id)
    {
        Log::debug("generating award letter");
        $awardLetter = AwardLetter::findOrFail($id);

        $signature_file_path = storage_path('/app/public/files/' . $awardLetter->approvedBy->signature_file);

        $type = pathinfo($signature_file_path, PATHINFO_EXTENSION);
        $data = file_get_contents($signature_file_path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        Log::debug($signature_file_path);

        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $contract_sum_in_words =  $digit->format($awardLetter->contract_sum);
        $contract_sum_in_words = ucwords($contract_sum_in_words);

        $dompdf = new Dompdf();

        // $response = view('award_letter', compact('awardLetter', 'contract_sum_in_words'));

        // $html = $response->render();

        // $pdf = PDF::loadHtml($html);
        // Log::debug('html loaded');

        // $pdf->render();
        // // write pdf to a file
        // Log::debug('outputing file');
        // $pdfFile = $pdf->output();
        // Log::debug('file outputed');

        // $file_name = str_replace("/", "_", $awardLetter->reference_no . '.pdf');
        // Storage::put('public/award_letters/' . $file_name, $pdfFile);
        // Log::debug("award letter generated");


        $html = view('award_letter', compact('awardLetter', 'contract_sum_in_words', 'base64'));
        $dompdf->loadHtml($html);

        $dompdf->render();
        // write pdf to a file
        $pdf = $dompdf->output();
        // file_put_contents("newfile555.pdf", $pdf);
        $file_name = str_replace("/", "_", $awardLetter->reference_no . '.pdf');
        Storage::put('public/award_letters/' . $file_name, $pdf);
        Log::debug("award letter generated");
    }

    public function viewPage($id)
    {
        $awardLetter = AwardLetter::findOrFail($id);

        // $signature_file_path = storage_path('app/public/files/' . $awardLetter->approvedBy->signature_file);

        // $signature_file_path = Storage::get('public/files/' . $awardLetter->approvedBy->signature_file);

        $signature_file_path = $awardLetter->approvedBy->signature_file;

        Log::debug($signature_file_path);

        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $contract_sum_in_words =  $digit->format($awardLetter->contract_sum);
        $contract_sum_in_words = ucwords($contract_sum_in_words);

        return view('award_letter', compact('awardLetter', 'contract_sum_in_words', 'signature_file_path'));
    }
}
