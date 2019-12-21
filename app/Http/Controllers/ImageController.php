<?php

namespace App\Http\Controllers;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;



class ImageController extends Controller
{
    public function create(Request $request)
    {
        $Extensions=Config::get('imageable.mimes');
        $imageExtensions = implode(',', $Extensions);
        $maxSize=Config::get('imageable.max_file_size');
        request()->validate([

            'image' => 'mimes:'.$imageExtensions.'|max:'.$maxSize.'',

        ]);
        $image=new Image();
        $file =$request->file('image');
        $random = Str::random(20);
        $filename = 'images/'.$random.'.'.$file->getClientOriginalExtension();
        Storage::disk('public')->put($filename, file_get_contents($file), 'public');
        $image->file_name=$filename;
        $image->imageable_type="categories";
        $image->imageable_id=38;
        if($image->save())
        {
            return 'image Created';
        }

    }
}
