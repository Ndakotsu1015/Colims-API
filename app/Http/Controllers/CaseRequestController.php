<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseRequestStoreRequest;
use App\Http\Requests\CaseRequestUpdateRequest;
use App\Http\Resources\CaseRequestCollection;
use App\Http\Resources\CaseRequestResource;
use App\Http\Resources\CourtCaseResource;
use App\Models\CaseRequest;
use App\Models\CourtCase;
use App\Models\CaseStatus;
use App\Models\SuitParty;
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
        $caseRequests = CaseRequest::with('initiator', 'caseReviewer')
            ->orderBy('updated_at', 'desc')->latest()->get();

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
            ->with('initiator', 'caseReviewer')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CaseRequestCollection($awaitingReviewerAssignment);
    }

    public function awaitingRecommendation(Request $request)
    {
        $awaitingRecommendation = CaseRequest::where('status', 'awaiting_recommendation')
            ->with('initiator', 'caseReviewer')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CaseRequestCollection($awaitingRecommendation);
    }

    public function awaitingApproval(Request $request)
    {
        $awaitingApproval = CaseRequest::where('status', 'awaiting_approval')
            ->with('initiator', 'caseReviewer')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CaseRequestCollection($awaitingApproval);
    }

    public function activeCaseRequests(Request $request)
    {
        $activeCaseRequests = CaseRequest::where('is_case_closed', false)
            ->with('initiator', 'caseReviewer')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CaseRequestCollection($activeCaseRequests);
    }

    public function closedCaseRequests(Request $request)
    {
        $closedCaseRequests = CaseRequest::where('is_case_closed', true)
            ->with('initiator', 'caseReviewer')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CaseRequestCollection($closedCaseRequests);
    }

    public function assignCaseReviewer(Request $request)
    {
        $data = $request->validate([
            'case_request_id' => 'required|integer',
            'case_reviewer_id' => 'required|integer',
        ]);

        $caseRequest = CaseRequest::findOrFail($data['case_request_id']);
        $caseRequest->case_reviewer_id = $data['case_reviewer_id'];
        $caseRequest->status = 'case_created';
        $caseRequest->save();

        return new CaseRequestResource($caseRequest->load('initiator', 'caseReviewer'));
    }

    public function caseReviewerRecommendation(Request $request)
    {
        $data = $request->validate([
            'case_request_id' => 'required|integer',
            'recommendation_note' => 'required|string',
            'should_go_to_trial' => 'required|boolean',
        ]);

        $caseRequest = CaseRequest::findOrFail($data['case_request_id']);
        $caseRequest->recommendation_note = $data['recommendation_note'];
        $caseRequest->should_go_to_trial = $data['should_go_to_trial'];
        $caseRequest->status = 'awaiting_approval';
        $caseRequest->save();

        return new CaseRequestResource($caseRequest->load('initiator', 'caseReviewer'));
    }

    public function caseRequestApproval(Request $request)
    {
        $data = $request->validate([
            'case_request_id' => 'required|integer',
            'solicitor_id' => 'required|integer|exists:solicitors,id',
            'handler_id' => 'required|integer|exists:users,id',
            'case_no' => 'required|string',
            'suitParties' => ''
        ]);

        Log::debug($data);

        $caseRequest = CaseRequest::findOrFail($data['case_request_id']);
        $data['posted_by'] = auth()->user()->id;
        $data['title'] = $caseRequest->title;
        $data['status'] = 'pending';        
        $data['case_status_id'] = CaseStatus::first()->id;

        /** @var CourtCase $courtCase */
        $courtCase = CourtCase::create($data);

        $suitParties = $data['suitParties'];
        Log::debug($suitParties);
        if (is_array($suitParties)) {
            foreach ($suitParties as $suitParty) {
                $suitParty['court_case_id'] = $courtCase->id;
                SuitParty::create($suitParty);
            }
        }

        $caseRequest->status = 'created';
        $caseRequest->is_case_closed = true;
        $caseRequest->save();

        return new CourtCaseResource($courtCase->load('postedBy', 'handler', 'solicitor', 'suitParties'));
    }

    public function caseRequestDiscarded(Request $request)
    {
        $data = $request->validate([
            'case_request_id' => 'required|integer',
        ]);

        $caseRequest = CaseRequest::findOrFail($data['case_request_id']);
        $caseRequest->status = 'discarded';
        $caseRequest->is_case_closed = true;
        $caseRequest->save();

        return new CaseRequestResource($caseRequest->load('initiator', 'caseReviewer'));
    }

    public function isCaseCreated($id)
    {
        $exists = CourtCase::where('case_request_id', $id)->exists();

        return $this->success($exists);
    }
}
