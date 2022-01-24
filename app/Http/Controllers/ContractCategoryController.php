<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContractCategoryStoreRequest;
use App\Http\Requests\ContractCategoryUpdateRequest;
use App\Http\Resources\ContractCategoryCollection;
use App\Http\Resources\ContractCategoryResource;
use App\Models\ContractCategory;
use Illuminate\Http\Request;

class ContractCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ContractCategoryCollection
     */
    public function index(Request $request)
    {
        $contractCategories = ContractCategory::all();

        return new ContractCategoryCollection($contractCategories);
    }

    /**
     * @param \App\Http\Requests\ContractCategoryStoreRequest $request
     * @return \App\Http\Resources\ContractCategoryResource
     */
    public function store(ContractCategoryStoreRequest $request)
    {
        $contractCategory = ContractCategory::create($request->validated());

        return new ContractCategoryResource($contractCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractCategory $contractCategory
     * @return \App\Http\Resources\ContractCategoryResource
     */
    public function show(Request $request, ContractCategory $contractCategory)
    {
        return new ContractCategoryResource($contractCategory);
    }

    /**
     * @param \App\Http\Requests\ContractCategoryUpdateRequest $request
     * @param \App\Models\ContractCategory $contractCategory
     * @return \App\Http\Resources\ContractCategoryResource
     */
    public function update(ContractCategoryUpdateRequest $request, ContractCategory $contractCategory)
    {
        $contractCategory->update($request->validated());

        return new ContractCategoryResource($contractCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ContractCategory $contractCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ContractCategory $contractCategory)
    {
        $contractCategory->delete();

        return response()->noContent();
    }
}
