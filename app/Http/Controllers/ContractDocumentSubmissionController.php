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

    public function authenticate($token, Request $request)
    {
        $rule = [
            'access_code' => 'required|string',
        ];
        $request->validate($rule);
        $ContractDocumentSubmission = ContractDocumentSubmission::where('url_token', $token)->first();

        if (!$ContractDocumentSubmission) {
            return response()->json([
                'message' => 'Invalid Document Submission Link. Please check and try again...',
            ], 400);
        }
        if ($ContractDocumentSubmission->access_code == $request->access_code) {
            if ($ContractDocumentSubmission->due_date < date('Y-m-d')) {
                return response()->json([
                    'message' => 'You can no longer use this link as the due date for document submission has been exceeded...',
                ], 400);
            } else {
                return new ContractDocumentSubmissionResource($ContractDocumentSubmission->load('entries', 'entries.contractDocumentType'));
            }
        } else {
            return response()->json([
                'message' => 'Invalid Access Code. Please check and try again...',
            ], 400);
        }
    }
}
