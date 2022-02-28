<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankStoreRequest;
use App\Http\Requests\BankUpdateRequest;
use App\Http\Resources\BankCollection;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\BankCollection
     */
    public function index(Request $request)
    {
        $banks = Bank::latest()->get();

        return new BankCollection($banks);
    }

    /**
     * @param \App\Http\Requests\BankStoreRequest $request
     * @return \App\Http\Resources\BankResource
     */
    public function store(BankStoreRequest $request)
    {
        $bank = Bank::create($request->validated());

        return new BankResource($bank);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \App\Http\Resources\BankResource
     */
    public function show(Request $request, Bank $bank)
    {
        return new BankResource($bank);
    }

    /**
     * @param \App\Http\Requests\BankUpdateRequest $request
     * @param \App\Models\Bank $bank
     * @return \App\Http\Resources\BankResource
     */
    public function update(BankUpdateRequest $request, Bank $bank)
    {
        $bank->update($request->validated());

        return new BankResource($bank);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Bank $bank)
    {
        $bank->delete();

        return response()->noContent();
    }
}
