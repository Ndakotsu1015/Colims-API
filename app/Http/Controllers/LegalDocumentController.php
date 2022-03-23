<?php

namespace App\Http\Controllers;

use App\Http\Requests\LegalDocumentStoreRequest;
use App\Http\Requests\LegalDocumentUpdateRequest;
use App\Http\Resources\LegalDocumentCollection;
use App\Http\Resources\LegalDocumentResource;
use App\Models\LegalDocument;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LegalDocumentController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\LegalDocumentCollection
     */
    public function index(Request $request)
    {
        $legalDocuments = LegalDocument::with('courtCase', 'user', 'documentType')->latest()->get();

        return new LegalDocumentCollection($legalDocuments);
    }

    /**
     * @param \App\Http\Requests\LegalDocumentStoreRequest $request
     * @return \App\Http\Resources\LegalDocumentResource
     */
    public function store(LegalDocumentStoreRequest $request)
    {
    	$data = $request->validated();
    	Log::debug('About to Log LegalDocument Data');
    	Log::debug($data);
    	$data['user_id'] = auth()->user()->id;
        $legalDocument = LegalDocument::create($data);

        $notification = new Notification();
        
        $notification->user_id = $legalDocument->courtCase->handler_id;        
        $notification->subject = 'New legal document has been uploaded';
        $notification->content = 'You just uploaded a new legal document for case with case no: ' . $legalDocument->courtCase->case_no. ' on ' . now();        
        $notification->action_link = env('APP_URL') . '/#/litigations/court-cases/' . $legalDocument->courtCase->id;
        $notification->save();

        $recipientEmail = $legalDocument->courtCase->handler->email;

        try {
            Mail::to($recipientEmail)->send(new \App\Mail\LegalDocument ($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }

        $notification1 = new Notification();

        $notification1->user_id = $legalDocument->courtCase->postedBy->id;
        $notification1->subject = 'New legal document has been uploaded';
        $notification1->content = 'Case Handler: ' . $legalDocument->courtCase->handler->name . ' just uploaded a new legal document for Case with Case No.: ' .$legalDocument->courtCase->case_no. ' on '.  now() . '.';
        $notification1->action_link = env('APP_URL') . '/#/litigations/court-cases/' . $legalDocument->courtCase->id;
        $notification1->save();

        $recipientEmail1 = $legalDocument->courtCase->postedBy->email;

        try {
            Mail::to($recipientEmail1)->send(new \App\Mail\LegalDocument ($notification1));
        } catch (Exception $e) {
            Log::debug($e);
        }        

        return new LegalDocumentResource($legalDocument->load('courtCase', 'user', 'documentType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LegalDocument $legalDocument
     * @return \App\Http\Resources\LegalDocumentResource
     */
    public function show(Request $request, LegalDocument $legalDocument)
    {
        return new LegalDocumentResource($legalDocument->load('courtCase', 'user', 'documentType'));
    }

    /**
     * @param \App\Http\Requests\LegalDocumentUpdateRequest $request
     * @param \App\Models\LegalDocument $legalDocument
     * @return \App\Http\Resources\LegalDocumentResource
     */
    public function update(LegalDocumentUpdateRequest $request, LegalDocument $legalDocument)
    {
        $legalDocument->update($request->validated());

        return new LegalDocumentResource($legalDocument->load('courtCase', 'user', 'documentType'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\LegalDocument $legalDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, LegalDocument $legalDocument)
    {
        $legalDocument->delete();

        return response()->noContent();
    }        
}
