<?php

namespace App\Http\Controllers\TOOLS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImgToolsController extends Controller
{
    public function addImage($folder, $file)
    {
        // set name image and get extension
        $name = time() . '.' . $file->getClientOriginalExtension();
        // destination path
        return Storage::putFileAs($folder, $file, $name);
    }
}
