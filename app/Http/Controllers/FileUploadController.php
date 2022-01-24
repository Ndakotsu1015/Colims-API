<?php

namespace App\Http\Controllers;

use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class FileUploadController extends Controller
{
    use JsonResponse;

    const LOG_KEY = 'FileUploadController';    
    public function upload(Request $request) 
    { 
        Log::info(self::LOG_KEY.' [upload] uploading...');
        $validated = $this->validate($request,[ 
            'file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:2048',
            'visibility' => ['required', Rule::in(['private', 'public'])]
        ]);    


        $file = $request->file('file');
        $visibility = $validated['visibility'];
        $path = $visibility == 'private' ? 'files' : 'public/files';
        $file->store($path);
        
        return response()->json([
            "success" => true,
            "message" => "File successfully uploaded",
            "data" => $file->hashName()
        ]);
        
      
    }

    public function getFile($filename, $visibility='private') 
    { 
        Log::info(self::LOG_KEY.' [get] getting file '. $filename);
        Log::debug($visibility);
        $filepath = $visibility == 'private' ? 'files/'.$filename : 'public/files/'.$filename;
        if(!Storage::exists($filepath))
        {
            return $this->error('File not found.', 404);
        }
        return Storage::response($filepath);
      
    }

}
