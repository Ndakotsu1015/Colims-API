<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseRequestStoreRequest;
use App\Http\Requests\CaseRequestUpdateRequest;
use App\Http\Resources\CaseRequestCollection;
use App\Http\Resources\CaseRequestResource;
use App\Models\CaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaseRequestController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseRequestCollection
     */
    public function index(Request $request)
    {
        $caseRequests = CaseRequest::with('initiator', 'caseReviewer')->get();

        return new CaseRequestCollection($caseRequests);
    }

    /**
     * @param \App\Http\Requests\CaseRequestStoreRequest $request
     * @return \App\Http\Resources\CaseRequestResource
     */
    public function store(CaseRequestStoreRequest $request)
    {
        $data = $request->validated();
        $data["initiator_id"] = auth()->user()->id;
        $data["status"] = "Pending";
        $caseRequest = CaseRequest::create($data);

        return new CaseRequestResource($caseRequest->load('initiator', 'caseReviewer'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseRequest $caseRequest
     * @return \App\Http\Resources\CaseRequestResource
     */
    public function show(Request $request, CaseRequest $caseRequest)
    {
        return new CaseRequestResource($caseRequest->load('initiator', 'caseReviewer'));
    }

    /**
     * @param \App\Http\Requests\CaseRequestUpdateRequest $request
     * @param \App\Models\CaseRequest $caseRequest
     * @return \App\Http\Resources\CaseRequestResource
     */
    public function update(CaseRequestUpdateRequest $request, CaseRequest $caseRequest)
    {
        $data = $request->validated();
        Log::debug($data);
        $caseRequest->update($data);
        Log::debug($caseRequest);

        return new CaseRequestResource($caseRequest->load('initiator', 'caseReviewer'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseRequest $caseRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseRequest $caseRequest)
    {
        $caseRequest->delete();

        return response()->noContent();
    }

    public function awaitingReviewerAssignment(Request $request)
    {
        $awaitingReviewerAssignment = CaseRequest::where('status', 'pending')
            ->with('initiator', 'caseReviewer')->get();

        return new CaseRequestCollection($awaitingReviewerAssignment);
    }

    public function awaitingRecommendation(Request $request)
    {
        $awaitingRecommendation = CaseRequest::where('status', 'awaiting_recommendation')
            ->with('initiator', 'caseReviewer')->get();

        return $awaitingRecommendation;
    }

    public function awaitingApproval(Request $request)
    {
        $awaitingApproval = CaseRequest::where('status', 'awaiting_approval')
            ->with('initiator', 'caseReviewer')->get();

        return $awaitingApproval;
    }

    public function activeCaseRequests(Request $request)
    {
        $activeCaseRequests = CaseRequest::where('is_case_closed', false)
            ->with('initiator', 'caseReviewer')->get();

        return $activeCaseRequests;
    }

    public function closedCaseRequests(Request $request)
    {
        $closedCaseRequests = CaseRequest::where('is_case_closed', true)
            ->with('initiator', 'caseReviewer')->get();

        return $closedCaseRequests;
    }
}
