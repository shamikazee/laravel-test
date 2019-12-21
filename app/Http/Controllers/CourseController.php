<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'status' => 'success',
            'message' => 'courses indexed successfully!',
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
                'status' => 'success',
                'message' => 'Course created successfully!',
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
        $course=Course::where('slug',$slug)->first();
        $course->category;
        return response()->json([
            'status' => 'success',
            'message' => 'Course retrieved successfully!',
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
    public function update(Request $request, $id)
    {
        $course=Course::find($id);
        $course->categoty_id=$request->input('categoty_id');
        $course->name=$request->input('name');
        $course->slug=$request->input('slug');
        $course->description=$request->input('description');
        if($course->save())
        {
            return 'course updated';
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course=Course::find($id);
        $image = $course->image;
        if($course->delete())
        {
            $image->delete();
            return 'Category deleted';
        }
    }
}
