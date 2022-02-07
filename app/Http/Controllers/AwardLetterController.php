<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardLetterStoreRequest;
use App\Http\Requests\AwardLetterUpdateRequest;
use App\Http\Resources\AwardLetterCollection;
use App\Http\Resources\AwardLetterResource;
use App\Models\AwardLetter;
use App\Models\BankReference;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AwardLetterController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AwardLetterCollection
     */
    public function index(Request $request)
    {
        $awardLetters = AwardLetter::with('contractor', 'contractType', 'state', 'project', 'duration', 'contractCategory', 'bankReferences', 'approvedBy')->get();

        return new AwardLetterCollection($awardLetters);
    }

    /**
     * @param \App\Http\Requests\AwardLetterStoreRequest $request
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function store(AwardLetterStoreRequest $request)
    {
        // Log::debug($request->validated());
        $awardLetter = AwardLetter::create($request->validated());

        return new AwardLetterResource($awardLetter);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetter $awardLetter
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function show(Request $request, AwardLetter $awardLetter)
    {
        return new AwardLetterResource($awardLetter->load('duration', 'contractCategory', 'bankReferences', 'contractor', 'contractType', 'state', 'project', 'approvedBy'));
    }

    /**
     * @param \App\Http\Requests\AwardLetterUpdateRequest $request
     * @param \App\Models\AwardLetter $awardLetter
     * @return \App\Http\Resources\AwardLetterResource
     */
    public function update(AwardLetterUpdateRequest $request, AwardLetter $awardLetter)
    {
        // Log::debug($request->validated());
        $awardLetter->update($request->validated());

        return new AwardLetterResource($awardLetter);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetter $awardLetter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AwardLetter $awardLetter)
    {
        $awardLetter->delete();

        return response()->noContent();
    }

    public function pending(Request $request)
    {
        $pendingAwardLetters = AwardLetter::doesntHave('bankReferences')->with('contractor', 'contractType', 'state', 'project', 'duration', 'contractCategory', 'approvedBy')->get();

        return new AwardLetterCollection($pendingAwardLetters);
    }

    public function awardLetterWithBankGuarantee(Request $request)
    {
        $awardLetterWithBankGaurantee = AwardLetter::with('contractor', 'contractType', 'state', 'project', 'duration', 'contractCategory', 'approvedBy', 'bankReferences')
            ->has('bankReferences')->get();

        return new AwardLetterCollection($awardLetterWithBankGaurantee);
    }

    public function awardLetterRenewals(Request $request)
    {
        $query = AwardLetter::with('bankReferences')->whereHas('bankReferences', function ($query) {
            $query->take(1)->orderBy('id', 'desc')->whereDate('reference_date', '<', now());
        })->getQuery();
        Log::debug($query->toSql());
        $data = $query->get();

        // $data = AwardLetter::with('bankReferences')
        //     ->when($awardLetter, function ($query) use ($awardLetter) {
        //         $query->whereHas('bankReferences', function($query) use ($awardLetter) {
        //             $query->where('reference_date', '<', now())->orderBy('id', 'desc')->take(1);
        //         });
        //     })->get();

        // Log::debug("Reference Date:");
        // foreach ($data as $datum) {
        //     // Log::debug("Date: {$datum->reference_date}");
        //     Log::debug($datum);
        //     Log::debug(now());
        // }


        return new AwardLetterCollection($data->load('contractor'));
    }
    
    public function checkRefNo(Request $request, string $refNo)
    {
        // $refNo = $request->get('refNo');
        $exists = AwardLetter::where('reference_no', $refNo)->exists();

        return $this->success($exists);
    }
}
