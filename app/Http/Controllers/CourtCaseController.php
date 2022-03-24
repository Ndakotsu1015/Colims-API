<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourtCaseStoreRequest;
use App\Http\Requests\CourtCaseUpdateRequest;
use App\Http\Resources\CalendarEventCollection;
use App\Http\Resources\CaseActivityCollection;
use App\Http\Resources\CourtCaseCollection;
use App\Http\Resources\CourtCaseResource;
use App\Http\Resources\LegalDocumentCollection;
use App\Http\Resources\SuitPartyCollection;
use App\Models\CalendarEvent;
use App\Models\CaseActivity;
use App\Models\CourtCase;
use App\Models\LegalDocument;
use App\Models\SuitParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourtCaseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CourtCaseCollection
     */
    public function index(Request $request)
    {
        $courtCases = CourtCase::with('handler', 'postedBy', 'caseStatus', 'solicitor', 'caseRequest', 'suitParties')->latest()->get();

        return new CourtCaseCollection($courtCases);
    }

    /**
     * @param \App\Http\Requests\CourtCaseStoreRequest $request
     * @return \App\Http\Resources\CourtCaseResource
     */
    public function store(CourtCaseStoreRequest $request)
    {
        $courtCase = CourtCase::create($request->validated());

        return new CourtCaseResource($courtCase->load('handler', 'postedBy', 'caseStatus', 'solicitor', 'caseRequest', 'suitParties'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CourtCase $courtCase
     * @return \App\Http\Resources\CourtCaseResource
     */
    public function show(Request $request, CourtCase $courtCase)
    {
        return new CourtCaseResource($courtCase->load('handler', 'postedBy', 'caseStatus', 'solicitor', 'caseRequest', 'suitParties'));
    }

    /**
     * @param \App\Http\Requests\CourtCaseUpdateRequest $request
     * @param \App\Models\CourtCase $courtCase
     * @return \App\Http\Resources\CourtCaseResource
     */
    public function update(CourtCaseUpdateRequest $request, CourtCase $courtCase)
    {
        $data = $request->validated();
        Log::debug("Court Case Request Data");
        Log::debug($data);

        $courtCase->update($data);

        return new CourtCaseResource($courtCase->load('handler', 'postedBy', 'caseStatus', 'solicitor', 'caseRequest', 'suitParties'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CourtCase $courtCase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CourtCase $courtCase)
    {
        $courtCase->delete();

        return response()->noContent();
    }

    public function getCalendarEvents($id)
    {
        $calendarEvents = CalendarEvent::where('court_case_id', $id)->latest()->get();

        return new CalendarEventCollection($calendarEvents);
    }

    public function getCaseActivities($id)
    {
        $caseActivities = CaseActivity::where('court_case_id', $id)->with('caseStatus', 'user', 'solicitor', 'caseActivitySuitParties', 'caseActivitySuitParties.suitParty')->latest()->get();

        return new CaseActivityCollection($caseActivities);
    }

    public function getLegalDocuments($id)
    {
        $legalDocuments = LegalDocument::where('court_case_id', $id)->with('documentType', 'user')->latest()->get();

        return new LegalDocumentCollection($legalDocuments);
    }

    public function getSuitParties($id)
    {
        $suitParties = SuitParty::where('court_case_id', $id)->latest()->get();

        return new SuitPartyCollection($suitParties);
    }

    public function updateCourtJudgement($id, Request $request)
    {
        Log::debug('Update Judgement');
        Log::debug($request->all());
        $rules = [
            'court_judgement' => 'required|string'
        ];
        $data = $request->validate($rules);
        Log::debug($data);

        $courtCase = CourtCase::where('id', $id)->first();
        $courtCase->update($data);

        return new CourtCaseResource($courtCase->load('handler', 'postedBy', 'caseStatus', 'solicitor', 'caseRequest', 'suitParties'));
    }

    public function activeCases(Request $request)
    {
        $activeCases = CourtCase::where('is_case_closed', false)
            ->with('caseStatus', 'postedBy', 'solicitor', 'handler', 'caseActivities')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CourtCaseCollection($activeCases);
    }

    public function closedCases(Request $request)
    {
        $closedCases = CourtCase::where('is_case_closed', true)
            ->with('caseStatus', 'postedBy', 'solicitor', 'handler', 'caseActivities')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CourtCaseCollection($closedCases);
    }

    // public function addSuitParty(Request $request) 
    // {
    //     $data = $request->all();

    // }
}
