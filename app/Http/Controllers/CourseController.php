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
        $course=Course::all();
        return $course;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $course=new Course;
        $course->categoty_id=$request->input('categoty_id');
        $course->name=$request->input('name');
        $course->slug=$request->input('slug');
        $course->description=$request->input('description');
        if($course->save())
        {
            return 'course Created';
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course=Course::find($id);
        return $course;
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
        if($course->delete())
        {
            return 'Category deleted';
        }
    }
}
