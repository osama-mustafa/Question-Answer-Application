<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{

    function handleUploadImage(Request $request, $inputName = 'image', $path = 'public/images')
    {

        // Validate image
        $request->validate([
            $inputName => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'dimensions:min_width=10,min_height=10'
            ],
        ]);

        // Create unique name for the image
        $file  = $request->$inputName;
        $name  =  $file->hashName();

        // Save image to specific directory
        $path = Storage::putFileAs($path, $file, $name);
        return $name;
    }
}
