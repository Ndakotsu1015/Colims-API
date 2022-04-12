<?php

namespace App\Http\Controllers;

use App\Enums\CourtStageType;
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
use App\Models\CaseStatus;
use App\Models\CourtCase;
use App\Models\LegalDocument;
use App\Models\SuitParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

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
            'court_judgement' => ['required', 'string'],
            'judgement_document_file' => ['required', 'string']
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

    public function activeTrialCases(Request $request)
    {
        $cases = CourtCase::where('is_case_closed', false)
            ->where('court_stage', CourtStageType::TRIAL_COURT)
            ->with('caseStatus', 'postedBy', 'solicitor', 'handler', 'caseActivities')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CourtCaseCollection($cases);
    }

    public function activeAppealCases(Request $request)
    {
        $cases = CourtCase::where('is_case_closed', false)
            ->whereIn('court_stage', [CourtStageType::APPEAL_COURT, CourtStageType::FINAL_COURT])
            ->with('caseStatus', 'postedBy', 'solicitor', 'handler', 'caseActivities')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CourtCaseCollection($cases);
    }

    public function activeFinalAppealCases(Request $request)
    {
        $cases = CourtCase::where('is_case_closed', false)
            ->where('court_stage', CourtStageType::FINAL_COURT)
            ->with('caseStatus', 'postedBy', 'solicitor', 'handler', 'caseActivities')
            ->orderBy('updated_at', 'desc')->latest()->get();

        return new CourtCaseCollection($cases);
    }

    public function closeCase(int $id)
    {
        /** @var CourtCase $courtCase */
        $courtCase = CourtCase::findOrFail($id);
        $courtCase->is_case_closed = true;
        $courtCase->save();

        return new CourtCaseResource($courtCase->load('handler', 'postedBy', 'caseStatus', 'solicitor', 'caseRequest', 'suitParties'));
    }

    public function reopenCase(int $id)
    {
        /** @var CourtCase $courtCase */
        $courtCase = CourtCase::findOrFail($id)->load('suitParties');

        if ($courtCase->court_stage >= 3) {
            return response([
                'message'   => 'This case has reached its final stage and can no longer be reopened.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $courtCase->has_moved = true;
        $courtCase->save();

        $courtStage = $courtCase->court_stage + 1;
        $newCourtCase = CourtCase::create([
            'title'             => $courtCase->title,
            'case_no'           => $courtCase->case_no . "-" . $courtStage,
            'court_stage'       => $courtStage,
            'is_case_closed'    => false,
            'case_request_id'   => $courtCase->case_request_id,
            'handler_id'        => $courtCase->handler_id,
            'solicitor_id'      => $courtCase->solicitor_id,
            'posted_by'         => auth()->user()->id,
            'case_status_id'    => CaseStatus::first()->id,
        ]);

        /** @var SuitParty $suitParty */
        foreach ($courtCase->suitParties as $suitParty) {
            $data = $suitParty->toArray();
            $data['court_case_id'] = $newCourtCase->id;
            SuitParty::create($data);
        }

        return new CourtCaseResource($newCourtCase->load('handler', 'postedBy', 'caseStatus', 'solicitor', 'caseRequest', 'suitParties'));
    }
}
