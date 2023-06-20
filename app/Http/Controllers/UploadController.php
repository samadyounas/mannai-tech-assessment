<?php

namespace App\Http\Controllers;

use App\Models\temporaryFile;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadImage(Request $request){
        if($request->hasFile('filepond')){
            $file = $request->file('filepond');
            $fileName = $file->getClientOriginalName();
            $folder = uniqid().'-'.now()->timestamp;
            $file->storeAs('/public/avatars/', $fileName);
            
            temporaryFile::create([
                'folder' => $folder,
                'fileName' => $fileName,
                'user_id' => 22, #for testing porpose i use dummy user id
            ]);
        }
        return 'not found';
    }
    public function removeImage($file){
        Storage::delete('/public/avatars/'.$file);
    }
}
