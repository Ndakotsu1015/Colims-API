<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChartTypeStoreRequest;
use App\Http\Requests\ChartTypeUpdateRequest;
use App\Http\Resources\ChartTypeCollection;
use App\Http\Resources\ChartTypeResource;
use App\Models\ChartType;
use Illuminate\Http\Request;

class ChartTypeController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ChartTypeCollection
     */
    public function index(Request $request)
    {
        $chartTypes = ChartType::with('chartCategory')->get();

        return new ChartTypeCollection($chartTypes);
    }

    /**
     * @param \App\Http\Requests\ChartTypeStoreRequest $request
     * @return \App\Http\Resources\ChartTypeResource
     */
    public function store(ChartTypeStoreRequest $request)
    {
        $chartType = ChartType::create($request->validated());

        return new ChartTypeResource($chartType->load('chartCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ChartType $chartType
     * @return \App\Http\Resources\ChartTypeResource
     */
    public function show(Request $request, ChartType $chartType)
    {
        return new ChartTypeResource($chartType->load('chartCategory'));
    }

    /**
     * @param \App\Http\Requests\ChartTypeUpdateRequest $request
     * @param \App\Models\ChartType $chartType
     * @return \App\Http\Resources\ChartTypeResource
     */
    public function update(ChartTypeUpdateRequest $request, ChartType $chartType)
    {
        $chartType->update($request->validated());

        return new ChartTypeResource($chartType->load('chartCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ChartType $chartType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ChartType $chartType)
    {
        $chartType->delete();

        return response()->noContent();
    }
}
