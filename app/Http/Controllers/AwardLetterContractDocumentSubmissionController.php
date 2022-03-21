<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractDocumentSubmissionStoreRequest;
use App\Http\Requests\ContractDocumentSubmissionUpdateRequest;
use App\Http\Resources\ContractDocumentSubmissionCollection;
use App\Http\Resources\ContractDocumentSubmissionResource;
use App\Models\ContractDocumentSubmission;
use Illuminate\Http\Request;

class ContractDocumentSubmissionController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContractDocumentSubmissionCollection
     */
    public function index(Request $request)
    {
        $ContractDocumentSubmissions = ContractDocumentSubmission::all();

        return new ContractDocumentSubmissionCollection($ContractDocumentSubmissions);
    }

    /**
     * @param \App\Http\Requests\ContractDocumentSubmissionStoreRequest $request
     * @return \App\Http\Resources\ContractDocumentSubmissionResource
     */
    public function store(ContractDocumentSubmissionStoreRequest $request)
    {
        $ContractDocumentSubmission = ContractDocumentSubmission::create($request->validated());

        return new ContractDocumentSubmissionResource($ContractDocumentSubmission);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractDocumentSubmission $ContractDocumentSubmission
     * @return \App\Http\Resources\ContractDocumentSubmissionResource
     */
    public function show(Request $request, ContractDocumentSubmission $ContractDocumentSubmission)
    {
        return new ContractDocumentSubmissionResource($ContractDocumentSubmission);
    }

    /**
     * @param \App\Http\Requests\ContractDocumentSubmissionUpdateRequest $request
     * @param \App\Models\ContractDocumentSubmission $ContractDocumentSubmission
     * @return \App\Http\Resources\ContractDocumentSubmissionResource
     */
    public function update(ContractDocumentSubmissionUpdateRequest $request, ContractDocumentSubmission $ContractDocumentSubmission)
    {
        $ContractDocumentSubmission->update($request->validated());

        return new ContractDocumentSubmissionResource($ContractDocumentSubmission);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractDocumentSubmission $ContractDocumentSubmission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ContractDocumentSubmission $ContractDocumentSubmission)
    {
        $ContractDocumentSubmission->delete();

        return response()->noContent();
    }
}
