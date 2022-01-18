<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChartCategoryStoreRequest;
use App\Http\Requests\ChartCategoryUpdateRequest;
use App\Http\Resources\ChartCategoryCollection;
use App\Http\Resources\ChartCategoryResource;
use App\Models\ChartCategory;
use Illuminate\Http\Request;

class ChartCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ChartCategoryCollection
     */
    public function index(Request $request)
    {
        $chartCategories = ChartCategory::with('chartProvider')->get();

        return new ChartCategoryCollection($chartCategories);
    }

    /**
     * @param \App\Http\Requests\ChartCategoryStoreRequest $request
     * @return \App\Http\Resources\ChartCategoryResource
     */
    public function store(ChartCategoryStoreRequest $request)
    {
        $chartCategory = ChartCategory::create($request->validated());

        return new ChartCategoryResource($chartCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ChartCategory $chartCategory
     * @return \App\Http\Resources\ChartCategoryResource
     */
    public function show(Request $request, ChartCategory $chartCategory)
    {
        return new ChartCategoryResource($chartCategory);
    }

    /**
     * @param \App\Http\Requests\ChartCategoryUpdateRequest $request
     * @param \App\Models\ChartCategory $chartCategory
     * @return \App\Http\Resources\ChartCategoryResource
     */
    public function update(ChartCategoryUpdateRequest $request, ChartCategory $chartCategory)
    {
        $chartCategory->update($request->validated());

        return new ChartCategoryResource($chartCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ChartCategory $chartCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ChartCategory $chartCategory)
    {
        $chartCategory->delete();

        return response()->noContent();
    }
}
