<?php 

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait ImageTrait {

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'image',
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image')->store('images', 'public');
            return $image;
        } 
    }
}
