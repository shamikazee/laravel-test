<?php

namespace App\Http\Controllers;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Config;


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
        $destinationPath = public_path(). '/images/';
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $image->file_name=$filename;
        $image->imageable_type="Category";
        $image->imageable_id=35;
        if($image->save())
        {
            return 'image Created';
        }

    }
}
