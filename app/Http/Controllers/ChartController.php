<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChartStoreRequest;
use App\Http\Requests\ChartUpdateRequest;
use App\Http\Resources\ChartCollection;
use App\Http\Resources\ChartResource;
use App\Models\Chart;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ChartCollection
     */
    public function index(Request $request)
    {
        $charts = Chart::with('module', 'chartType', 'chartCategory')->get();

        return new ChartCollection($charts);
    }

    /**
     * @param \App\Http\Requests\ChartStoreRequest $request
     * @return \App\Http\Resources\ChartResource
     */
    public function store(ChartStoreRequest $request)
    {
        $chart = Chart::create($request->validated());

        return new ChartResource($chart);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chart $chart
     * @return \App\Http\Resources\ChartResource
     */
    public function show(Request $request, Chart $chart)
    {
        return new ChartResource($chart);
    }

    /**
     * @param \App\Http\Requests\ChartUpdateRequest $request
     * @param \App\Models\Chart $chart
     * @return \App\Http\Resources\ChartResource
     */
    public function update(ChartUpdateRequest $request, Chart $chart)
    {
        $chart->update($request->validated());

        return new ChartResource($chart);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chart $chart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Chart $chart)
    {
        $chart->delete();

        return response()->noContent();
    }
}
