<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseActivityStoreRequest;
use App\Http\Requests\CaseActivityUpdateRequest;
use App\Http\Resources\CaseActivityCollection;
use App\Http\Resources\CaseActivityResource;
use App\Models\CaseActivity;
use App\Models\CaseActivitySuitParty;
use App\Models\CourtCase;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CaseActivityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseActivityCollection
     */
    public function index(Request $request)
    {
        $caseActivities = CaseActivity::with('courtCase', 'user', 'solicitor', 'caseActivitySuitParties')->latest()->get();

        return new CaseActivityCollection($caseActivities);
    }

    /**
     * @param \App\Http\Requests\CaseActivityStoreRequest $request
     * @return \App\Http\Resources\CaseActivityResource
     */
    public function store(CaseActivityStoreRequest $request)
    {
        $data = $request->validated();

        $courtCase = CourtCase::findOrFail($data['court_case_id']);
        $data['user_id'] = auth()->user()->id;
        $data['solicitor_id'] = $courtCase->solicitor_id;

        $caseActivity = CaseActivity::create($data);   
        
        if (is_array($request->suit_parties)) {
            foreach ($request->suit_parties as $suitPartyId) {
                $caseActivitySuitParty = new CaseActivitySuitParty();
                $caseActivitySuitParty->case_activity_id = $caseActivity->id;
                $caseActivitySuitParty->suit_party_id = $suitPartyId;
                $caseActivitySuitParty->save();
            }
        }

        $courtCase->case_status_id = $caseActivity->case_status_id;
        $courtCase->save();
        
        $notification = new Notification();

        $notification->user_id = auth()->user()->id;
        $notification->subject = 'New Case Activity Recorded';
        $notification->content = 'You just recorded a new case activity entry for Case with Case No: ' . $courtCase->case_no. "on ". now() . ".";        
        $notification->save();
        
        $recipientEmail = auth()->user()->email;
        Mail::to($recipientEmail)->send(new \App\Mail\CaseActivity ($notification));

        $notification2 = new Notification();

        $notification2->user_id = $courtCase->postedBy->id;
        $notification2->subject = 'New Case Activity Recorded';
        $notification2->content = 'Case Handler: ' . $courtCase->handler->name." just recorded a new case activity entry for Case with Case No.: ".$courtCase->case_no. "on ". now() . ".";
        $notification2->save();

        $recipientEmail2 = $courtCase->postedBy->email;
        Mail::to($recipientEmail2)->send(new \App\Mail\CaseActivity ($notification2));

        $notification3 = new Notification();

        $notification3->user_id = $courtCase->postedBy->id;
        $notification3->subject = 'Case Status Change';
        $notification3->content = 'A case with the case no.: ' .$courtCase->case_no. ' was changed from ' .$caseActivity->caseStatus->name. 'status to' .$courtCase->caseStatus->name. 'status on' . now();
        $notification3->save();

        $recipientEmail3 = $courtCase->postedBy->email;
        Mail::to($recipientEmail3)->send(new \App\Mail\CaseActivity ($notification3));

        return new CaseActivityResource($caseActivity->load('courtCase', 'user', 'solicitor', 'caseActivitySuitParties', 'caseActivitySuitParties.suitParty'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseActivity $caseActivity
     * @return \App\Http\Resources\CaseActivityResource
     */
    public function show(Request $request, CaseActivity $caseActivity)
    {
        return new CaseActivityResource($caseActivity->load('courtCase', 'user', 'solicitor', 'caseActivitySuitParties', 'caseActivitySuitParties.suitParty'));
    }

    /**
     * @param \App\Http\Requests\CaseActivityUpdateRequest $request
     * @param \App\Models\CaseActivity $caseActivity
     * @return \App\Http\Resources\CaseActivityResource
     */
    public function update(CaseActivityUpdateRequest $request, CaseActivity $caseActivity)
    {
        $caseActivity->update($request->validated());

        return new CaseActivityResource($caseActivity->load('courtCase', 'user', 'solicitor', 'caseActivitySuitParties', 'caseActivitySuitParties.suitParty'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseActivity $caseActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CaseActivity $caseActivity)
    {
        $caseActivity->delete();

        return response()->noContent();
    }
}
