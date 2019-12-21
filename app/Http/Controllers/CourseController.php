<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App;

class CourseController extends Controller
{
    public $local='en';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        App::setLocale($this->local);
        $course=Course::paginate(10);
        foreach ($course as $c)
                {
                    if((array)$c->image)
                    {
                        $c->image['url']='http://localhost:8000/storage/'.$c->image['file_name'];
                    }
                    $c->category;
                    if((array)$c->category->image)
                    {
                        $c->category->image['url']='http://localhost:8000/storage/'.$c->category->image['file_name'];
                    }
                }

        return response()->json([
            'status' => __('response.status'),
            'message' => 'courses '.__('response.message.index'),
            'courses' =>$course
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        App::setLocale($this->local);
        $course=new Course;
        $name='';
        $slug='';

        if (!$request->filled('name')) {
            $request->flashOnly('slug');
                return response()->json([
                    'status' => 'The given data was invalid.',
                    'errors' => [
                        'name' =>[
                            "The name field is required."
                        ],
                        'slug' => [
                            "The slug has already been taken."
                        ]
                    ]
                        
                ]);
            }
        elseif($request->filled(['name','slug']))
        {
            $slug=$request->input('slug');
            $name=$request->input('name');   
        }
        elseif (!$request->has('slug') && $request->filled('name')) {
            $name=$request->input('name');
            if($request->old('slug')){
                $slug=$request->old('slug');
            }
            else{
                $slug=$newout=str_replace(" ", "-", $name);
            }
            
        }
        $course->category_id=$request->input('category_id');
        $course->name=$name;
        $course->description=$request->input('description');
        $course->slug=$slug;

        if($course->save())
        {
            $course->image=$request->input('image');
            return response()->json([
                'status' => __('response.status'),
                'message' => 'course '.__('response.message.create'),
                'course' =>$course
                ]);
        }

        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        App::setLocale($this->local);
        $course=Course::where('slug',$slug)->first();
        $course->category;
        (array)$course;
        $course->image;
        $filename=$course->image['file_name'];
        unset($course['image']); 
        $course['image']='http://localhost:8000/storage/'.$filename;

        return response()->json([
            'status' => __('response.status'),
            'message' => 'course '.__('response.message.show'),
            'Course' =>$course
            ]);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        App::setLocale($this->local);

        $course=Course::where('slug',$slug)->first();
        if($request->has(['name']))
        {
            $course->name=$request->input('name');
        }
        if ($request->has(['category_id']))
        {
            $course->category_id=$request->input('category_id');
        }
        if ($request->has(['slug']))
        {
            $course->slug=$request->input('slug');
        }
        if ($request->has(['description']))
        {
            $course->description=$request->input('description');
        }
        if($course->save())
        {
            if($request->has(['image']))
            {
                $course->image=$request->input('image');
            }
            $course->category;
            return response()->json([
                'status' => __('response.status'),
                'message' => 'courses '.__('response.message.update'),
                'Course' =>$course
                ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        App::setLocale($this->local);

        $course=Course::where('slug',$slug)->first();
        $empty=true;
        if($course->image)
        {
            $image = $course->image;
            $empty=false;
        }
        if($course->delete())
        {
            if(!$empty)
            {
                $image->delete();
            }
            return response()->json([
                'status' => __('response.status'),
                'message' => 'courses '.__('response.message.delete')
                ]);
        }
    }
}
