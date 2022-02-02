<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankReferenceStoreRequest;
use App\Http\Requests\BankReferenceUpdateRequest;
use App\Http\Resources\BankReferenceCollection;
use App\Http\Resources\BankReferenceResource;
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
        $bankReferences = BankReference::with('awardLetter', 'awardLetter.contractor', 'awardLetter.state')->get();

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

        return new BankReferenceResource($bankReference);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\BankReference $bankReference
     * @return \App\Http\Resources\BankReferenceResource
     */
    public function show(Request $request, BankReference $bankReference)
    {
        return new BankReferenceResource($bankReference);
    }

    /**
     * @param \App\Http\Requests\BankReferenceUpdateRequest $request
     * @param \App\Models\BankReference $bankReference
     * @return \App\Http\Resources\BankReferenceResource
     */
    public function update(BankReferenceUpdateRequest $request, BankReference $bankReference)
    {
        $bankReference->update($request->validated());

        return new BankReferenceResource($bankReference);
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
}
