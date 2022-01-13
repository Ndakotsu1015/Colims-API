<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChartProviderStoreRequest;
use App\Http\Requests\ChartProviderUpdateRequest;
use App\Http\Resources\ChartProviderCollection;
use App\Http\Resources\ChartProviderResource;
use App\Models\ChartProvider;
use Illuminate\Http\Request;

class ChartProviderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ChartProviderCollection
     */
    public function index(Request $request)
    {
        $chartProviders = ChartProvider::all();

        return new ChartProviderCollection($chartProviders);
    }

    /**
     * @param \App\Http\Requests\ChartProviderStoreRequest $request
     * @return \App\Http\Resources\ChartProviderResource
     */
    public function store(ChartProviderStoreRequest $request)
    {
        $chartProvider = ChartProvider::create($request->validated());

        return new ChartProviderResource($chartProvider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ChartProvider $chartProvider
     * @return \App\Http\Resources\ChartProviderResource
     */
    public function show(Request $request, ChartProvider $chartProvider)
    {
        return new ChartProviderResource($chartProvider);
    }

    /**
     * @param \App\Http\Requests\ChartProviderUpdateRequest $request
     * @param \App\Models\ChartProvider $chartProvider
     * @return \App\Http\Resources\ChartProviderResource
     */
    public function update(ChartProviderUpdateRequest $request, ChartProvider $chartProvider)
    {
        $chartProvider->update($request->validated());

        return new ChartProviderResource($chartProvider);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ChartProvider $chartProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ChartProvider $chartProvider)
    {
        $chartProvider->delete();

        return response()->noContent();
    }
}
