<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseRequestStoreRequest;
use App\Http\Requests\CaseRequestUpdateRequest;
use App\Http\Resources\CaseRequestCollection;
use App\Http\Resources\CaseRequestResource;
use App\Http\Resources\CourtCaseResource;
use App\Models\CaseDraft;
use App\Models\CaseRequest;
use App\Models\CourtCase;
use App\Models\CaseStatus;
use App\Models\Notification;
use App\Models\SuitParty;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = "Case Request Created";
        $notification->content = "A new case request with Title : " . $caseRequest->title . "was created by you on ". now() . ".";
        $notification->action_link = env("CLIENT_URL") . "/#/litigations/case-requests/list";
        $notification->save();

        $caseDraft = new CaseDraft();
        $caseDraft->case_no = $caseRequest->case_no;
        $caseDraft->title = $caseRequest->title;
        $caseDraft->dls_approved = $caseRequest->dls_approved;        
        $caseDraft->review_submitted = false;
        $caseDraft->review_comment = $caseRequest->review_comment;
        $caseDraft->handler_id = $caseRequest->handler_id;
        $caseDraft->solicitor_id = $caseRequest->solicitor_id;
        $caseDraft->case_request_id = $caseRequest->id;
        $caseDraft->save();        

        $recipientEmail = auth()->user()->email;

        try {
            Mail::to($recipientEmail)->send(new \App\Mail\CaseRequest ($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }        

        return new CaseRequestResource($caseRequest->load('initiator', 'caseReviewer', 'caseDraft'));
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

        $notification = new Notification();

        $notification->user_id = $caseRequest->case_reviewer_id;
        $notification->subject = "Case Reviewer Assigned";
        $notification->content = "You have been assigned to review a case request with Title : " . $caseRequest->title . " from ". auth()->user()->name. " on ". now() . ".";
        $notification->action_link = env("CLIENT_URL") . "/#/litigations/case-requests/assign-case-reviewer/" . $caseRequest->id;
        $notification->save();

        $recipientEmail = $caseRequest->caseReviewer->email;
        try {
            Mail::to($recipientEmail)->send(new \App\Mail\CaseReviewerAssignment ($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }        

        $notification1 = new Notification();

        $notification1->user_id = auth()->user()->email;
        $notification1->subject = "Case Reviewer Assigned";
        $notification1->content = "You have assigned a case request with Title : " . $caseRequest->title . " to " . $caseRequest->caseReviewer->name . " to reviewer on ". now() . ".";
        // $notification1->action_link = env("CLIENT_URL") . "/case-requests/" . $caseRequest->id;
        $notification1->save();

        $recipientEmail1 = auth()->user()->email;
        try {
            Mail::to($recipientEmail1)->send(new \App\Mail\CaseReviewerAssignment ($notification1));
        } catch (Exception $e) {
            Log::debug($e);
        }        

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

        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = "Case Recommendation";
        $notification->content = "You just made a recommendation to a Case Request with title : " . $caseRequest->title ." on ". now() . ".";
        // $notification->action_link = env("CLIENT_URL") . "/case-requests/" . $caseRequest->id;
        $notification->save();

        $recipientEmail = auth()->user()->email;
        try {
            Mail::to($recipientEmail)->send(new \App\Mail\CaseRequestRecommendation ($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }        

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

        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = "Case Approved";
        $notification->content = "You have just approved a Case Request with Case No : " . $courtCase->case_no ." on ". now() . ". You have also assigned a Case Handler: " . $courtCase->handler->name . " and External Solicitor: " . $courtCase->solicitor->name . ". to the case";
        $notification->action_link = env("CLIENT_URL") . "/#/litigations/case/details/" . $courtCase->id;
        $notification->save();

        $recipientEmail = auth()->user()->email;
        try {
            Mail::to($recipientEmail)->send(new \App\Mail\CaseRequestApproval ($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }        

        $notification1 = new Notification();

        $notification1->user_id = auth()->user()->id;
        $notification1->subject = "Case Created";
        $notification1->content = "You have just created a Case with Case No : " . $courtCase->case_no ." on ". now() . ".";
        $notification1->action_link = env("CLIENT_URL") . "/#/litigations/court-cases/" . $courtCase->id;
        $notification1->save();
        
        $recipientEmail1 = auth()->user()->email;
        try {
            Mail::to($recipientEmail1)->send(new \App\Mail\CaseRequestApproval ($notification1));
        } catch (Exception $e) {
            Log::debug($e);
        }        

        $notification2 = new Notification();

        $notification2->user_id = $courtCase->handler->id;
        $notification2->subject = "Case Created";
        $notification2->content = "You have been assigned as a Case Handler to a case with Case No : " . $courtCase->case_no ." on ". now() . ".";
        $notification2->action_link = env("CLIENT_URL") . "/#/litigations/court-cases/" . $courtCase->id;
        $notification2->save();

        $recipientEmail2 = $courtCase->handler->email;
        try {
            Mail::to($recipientEmail2)->send(new \App\Mail\CaseRequestApproval ($notification2));        
        } catch (Exception $e) {
            Log::debug($e);
        }        

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
        
        $notification = new Notification();
        $notification->user_id = auth()->user()->id;
        $notification->subject = "Case Request Discarded";
        $notification->content = "You just discarded a Case Request with title : " . $caseRequest->title ." on ". now() . ".";
        $notification->save();
        
        $recipientEmail = auth()->user()->email;
        try {
            Mail::to($recipientEmail)->send(new \App\Mail\CaseRequestDiscarded ($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }

        return new CaseRequestResource($caseRequest->load('initiator', 'caseReviewer'));
    }

    public function isCaseCreated($id)
    {
        $exists = CourtCase::where('case_request_id', $id)->exists();

        return $this->success($exists);
    }
}
