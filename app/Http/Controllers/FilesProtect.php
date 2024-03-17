<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Response, File;

class FilesProtect extends Controller
{
    public function archivo($archivo){
        
        $archivo = str_replace('|','/',$archivo);
        $path = "userfiles/{$archivo}";
        $ext = explode('.', $archivo);
        $filename = "instel_".date('YmdHis').".".$ext[1];

        if(Storage::exists($path)){
            return Response::make(Storage::get($path), 200, [
                'Content-Type' => Storage::mimeType($path),
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }
        abort('404');
    }
}
