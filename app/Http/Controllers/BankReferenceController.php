<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankReferenceStoreRequest;
use App\Http\Requests\BankReferenceUpdateRequest;
use App\Http\Resources\BankReferenceCollection;
use App\Http\Resources\BankReferenceResource;
use App\Models\AwardLetter;
use App\Models\BankReference;
use Illuminate\Http\Request;

class BankReferenceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\BankReferenceCollection
     */
    public function index(Request $request)
    {
        $bankReferences = BankReference::with('affiliate', 'awardLetter', 'awardLetter.contractor', 'awardLetter.approvedBy', 'awardLetter.state')->latest()->get();

        return new BankReferenceCollection($bankReferences);
    }

    /**
     * @param \App\Http\Requests\BankReferenceStoreRequest $request
     * @return \App\Http\Resources\BankReferenceResource
     */
    public function store(BankReferenceStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = auth()->user()->id;
        $bankReference = BankReference::create($data);

        $awardLetter = AwardLetter::find($request->award_letter_id);
        $awardLetter->last_bank_ref_date = $bankReference->reference_date;
        $awardLetter->save();


        return new BankReferenceResource($bankReference->load('affiliate', 'awardLetter', 'awardLetter.contractor', 'awardLetter.approvedBy', 'awardLetter.state'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankReference $bankReference
     * @return \App\Http\Resources\BankReferenceResource
     */
    public function show(Request $request, BankReference $bankReference)
    {
        return new BankReferenceResource($bankReference->load('awardLetter', 'affiliate', 'affiliate.bank', 'awardLetter.contractor', 'awardLetter.approvedBy', 'awardLetter.state'));
    }

    /**
     * @param \App\Http\Requests\BankReferenceUpdateRequest $request
     * @param \App\Models\BankReference $bankReference
     * @return \App\Http\Resources\BankReferenceResource
     */
    public function update(BankReferenceUpdateRequest $request, BankReference $bankReference)
    {
        $bankReference->update($request->validated());

        return new BankReferenceResource($bankReference->load('affiliate', 'awardLetter', 'awardLetter.contractor', 'awardLetter.approvedBy', 'awardLetter.state'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankReference $bankReference
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BankReference $bankReference)
    {
        $bankReference->delete();

        return response()->noContent();
    }

    public function checkRefNo(Request $request, string $refNo)
    {
        $exists = BankReference::where('reference_no', $refNo)->exists();

        return $this->success($exists);
    }
}
