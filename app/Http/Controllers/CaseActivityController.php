<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseActivityStoreRequest;
use App\Http\Requests\CaseActivityUpdateRequest;
use App\Http\Resources\CaseActivityCollection;
use App\Http\Resources\CaseActivityResource;
use App\Models\CaseActivity;
use Illuminate\Http\Request;

class CaseActivityController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\CaseActivityCollection
     */
    public function index(Request $request)
    {
        $caseActivities = CaseActivity::with('courtCase', 'user')->get();

        return new CaseActivityCollection($caseActivities);
    }

    /**
     * @param \App\Http\Requests\CaseActivityStoreRequest $request
     * @return \App\Http\Resources\CaseActivityResource
     */
    public function store(CaseActivityStoreRequest $request)
    {
        $caseActivity = CaseActivity::create($request->validated());

        return new CaseActivityResource($caseActivity);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\CaseActivity $caseActivity
     * @return \App\Http\Resources\CaseActivityResource
     */
    public function show(Request $request, CaseActivity $caseActivity)
    {
        return new CaseActivityResource($caseActivity);
    }

    /**
     * @param \App\Http\Requests\CaseActivityUpdateRequest $request
     * @param \App\Models\CaseActivity $caseActivity
     * @return \App\Http\Resources\CaseActivityResource
     */
    public function update(CaseActivityUpdateRequest $request, CaseActivity $caseActivity)
    {
        $caseActivity->update($request->validated());

        return new CaseActivityResource($caseActivity);
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
