<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractDocumentSubmissionEntryUpdateRequest;
use App\Http\Requests\ContractDocumentSubmissionStoreRequest;
use App\Http\Requests\ContractDocumentSubmissionUpdateRequest;
use App\Http\Resources\ContractDocumentSubmissionCollection;
use App\Http\Resources\ContractDocumentSubmissionEntryResource;
use App\Http\Resources\ContractDocumentSubmissionResource;
use App\Models\ContractDocumentSubmission;
use App\Models\ContractDocumentSubmissionEntry;
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
        if ($ContractDocumentSubmission->access_code != $request->access_code) {
            return response()->json([
                'message' => 'Invalid Access Code. Please check and try again...',
            ], 400);
        }

        if ($ContractDocumentSubmission->due_date < date('Y-m-d')) {
            return response()->json([
                'message' => 'You can no longer use this link as the due date for document submission has been exceeded...',
            ], 400);
        }

        if ($ContractDocumentSubmission->is_submitted == true) {
            return response()->json([
                'message' => 'Your document submission was successful and is awaiting approval',
            ], 400);
        }

        if ($ContractDocumentSubmission->is_approved == true) {
            return response()->json([
                'message' => 'You can no longer use this link as the document submission has been approved...',
            ], 400);
        }

        return new ContractDocumentSubmissionResource($ContractDocumentSubmission->load('entries', 'entries.contractDocumentType'));
    }

    public function uploadSubmissionEntry(int $id, Request $request)
    {
        $rules = [
            'name'  => ['required', 'string'],
            'filename'  => ['required', 'string'],
        ];
        $data = $request->validate($rules);
        $entry = ContractDocumentSubmissionEntry::findOrFail($id);
        $entry->update($data);

        return new ContractDocumentSubmissionEntryResource($entry);
    }

    public function submitForApproval(int $id)
    {
        $submission = ContractDocumentSubmission::findOrFail($id);
        $submission->load('entries');
        $upload_not_completed = false;
        foreach ($submission->entries as $entry) {
            if ($entry->filename == null) {
                $upload_not_completed = true;
                break;
            }
        }

        if ($upload_not_completed) {
            return response()->json([
                'message' => 'Document Submission not yet completed. Please verify and try again...',
            ], 400);
        }

        $submission->is_submitted = true;
        $submission->save();

        return new ContractDocumentSubmissionResource($submission->load('entries', 'entries.contractDocumentType'));
    }
}
