<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardLetterStoreRequest;
use App\Http\Requests\AwardLetterUpdateRequest;
use App\Http\Resources\AwardLetterCollection;
use App\Http\Resources\AwardLetterResource;
use App\Models\AwardLetter;
use App\Models\BankReference;
use App\Models\Notification;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AwardLetterController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AwardLetterCollection
     */
    public function index(Request $request)
    {
        $awardLetters = AwardLetter::with('contractor', 'contractType', 'project', 'duration', 'contractCategory', 'bankReferences', 'approvedBy')->latest()->get();

        return new AwardLetterCollection($awardLetters);
    }

    /**
     * @param \App\Http\Requests\AwardLetterStoreRequest $request
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function store(AwardLetterStoreRequest $request)
    {
        Log::debug($request->validated());
        $awardLetter = AwardLetter::create($request->validated());

        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = "Award Letter Created";
        $notification->content = "A new award letter with Reference No. : " . $awardLetter->reference_no . "was created by you on " . now() . ".";
        $notification->action_link = env("CLIENT_URL") . "/#/contracts/award-letters/history";
        $notification->save();

        $recipientEmail = auth()->user()->email;

        try {
            Mail::to($recipientEmail)->queue(new \App\Mail\AwardLetter($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }

        return new AwardLetterResource($awardLetter->load('duration', 'contractCategory', 'bankReferences', 'contractor', 'contractType', 'project', 'approvedBy'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetter $awardLetter
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function show(Request $request, AwardLetter $awardLetter)
    {
        return new AwardLetterResource($awardLetter->load('duration', 'contractCategory', 'bankReferences', 'contractor', 'contractType', 'project', 'approvedBy'));
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

        return new AwardLetterResource($awardLetter->load('duration', 'contractCategory', 'bankReferences', 'contractor', 'contractType', 'project', 'approvedBy'));
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
        $pendingAwardLetters = AwardLetter::doesntHave('bankReferences')->with('contractor', 'contractType', 'project', 'duration', 'contractCategory', 'approvedBy')->latest()->get();

        return new AwardLetterCollection($pendingAwardLetters->load('contractor', 'contractType', 'project', 'duration', 'contractCategory', 'approvedBy', 'bankReferences'));
    }

    public function awardLetterWithBankGuarantee(Request $request)
    {
        $awardLetterWithBankGaurantee = AwardLetter::with('contractor', 'contractType', 'project', 'duration', 'contractCategory', 'approvedBy', 'bankReferences')
            ->has('bankReferences')->get();

        return new AwardLetterCollection($awardLetterWithBankGaurantee);
    }

    public function awardLetterRenewals(Request $request)
    {
        $data = AwardLetter::where('last_bank_ref_date', '<', now())->orderBy('id', 'desc')->latest()->get();

        return new AwardLetterCollection($data->load('contractor', 'contractType', 'project', 'duration', 'contractCategory', 'approvedBy', 'bankReferences'));
    }

    public function checkRefNo(Request $request, string $refNo)
    {

        $exists = AwardLetter::where('reference_no', $refNo)->first();

        return $this->success($exists);
    }
}
