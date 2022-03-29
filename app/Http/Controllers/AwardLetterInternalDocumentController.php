<?php

namespace App\Http\Controllers;

use App\Http\Requests\AwardLetterInternalDocumentStoreRequest;
use App\Http\Requests\AwardLetterInternalDocumentUpdateRequest;
use App\Http\Resources\AwardLetterInternalDocumentCollection;
use App\Http\Resources\AwardLetterInternalDocumentResource;
use App\Models\AwardLetterInternalDocument;
use Illuminate\Http\Request;

class AwardLetterInternalDocumentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\AwardLetterInternalDocumentCollection
     */
    public function index(Request $request)
    {
        $awardLetterInternalDocuments = AwardLetterInternalDocument::with('awardLetter', 'postedBy')->get();

        return new AwardLetterInternalDocumentCollection($awardLetterInternalDocuments);
    }

    /**
     * @param \App\Http\Requests\AwardLetterInternalDocumentStoreRequest $request
     * @return \App\Http\Resources\AwardLetterInternalDocumentResource
     */
    public function store(AwardLetterInternalDocumentStoreRequest $request)
    {
        $data = $request->validated();
        $data['posted_by'] = auth()->user()->id;
        $awardLetterInternalDocument = AwardLetterInternalDocument::create($data);

        return new AwardLetterInternalDocumentResource($awardLetterInternalDocument->load('postedBy'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetterInternalDocument $awardLetterInternalDocument
     * @return \App\Http\Resources\AwardLetterInternalDocumentResource
     */
    public function show(Request $request, AwardLetterInternalDocument $awardLetterInternalDocument)
    {
        // $awardLetterInternalDocument->load('postedBy');
        return new AwardLetterInternalDocumentResource($awardLetterInternalDocument->load('awardLetter', 'postedBy'));
    }

    /**
     * @param \App\Http\Requests\AwardLetterInternalDocumentUpdateRequest $request
     * @param \App\Models\AwardLetterInternalDocument $awardLetterInternalDocument
     * @return \App\Http\Resources\AwardLetterInternalDocumentResource
     */
    public function update(AwardLetterInternalDocumentUpdateRequest $request, AwardLetterInternalDocument $awardLetterInternalDocument)
    {
        $awardLetterInternalDocument->update($request->validated());

        return new AwardLetterInternalDocumentResource($awardLetterInternalDocument->load('postedBy'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AwardLetterInternalDocument $awardLetterInternalDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AwardLetterInternalDocument $awardLetterInternalDocument)
    {
        $awardLetterInternalDocument->delete();

        return response()->noContent();
    }
}
