<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseActivityStoreRequest;
use App\Http\Requests\CaseActivityUpdateRequest;
use App\Http\Resources\CaseActivityCollection;
use App\Http\Resources\CaseActivityResource;
use App\Models\CaseActivity;
use App\Models\CaseActivitySuitParty;
use App\Models\CourtCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        return new CaseActivityResource($caseActivity->load('courtCase', 'user', 'solicitor', 'caseActivitySuitParties'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseActivity $caseActivity
     * @return \App\Http\Resources\CaseActivityResource
     */
    public function show(Request $request, CaseActivity $caseActivity)
    {
        return new CaseActivityResource($caseActivity->load('courtCase', 'user', 'solicitor', 'caseActivitySuitParties'));
    }

    /**
     * @param \App\Http\Requests\CaseActivityUpdateRequest $request
     * @param \App\Models\CaseActivity $caseActivity
     * @return \App\Http\Resources\CaseActivityResource
     */
    public function update(CaseActivityUpdateRequest $request, CaseActivity $caseActivity)
    {
        $caseActivity->update($request->validated());

        return new CaseActivityResource($caseActivity->load('courtCase', 'user', 'solicitor', 'caseActivitySuitParties'));
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
