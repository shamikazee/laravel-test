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
        $image->file_name=$filename;
        $image->imageable_id=3;
        $image->imageable_type='categories';
        if($image->save())
        {
            Storage::disk('public')->put($filename, file_get_contents($file), 'public');
            (array)$image;
            $image['url']='http://localhost:8000/storage/'.$image['file_name'];
            return response()->json([
                'status' => 'success',
                'message' => 'messages.image_uploaded',
                'image' =>$image
                ]);
        }
        

    }
}
