<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::paginate(10);
        foreach ($category as $c)
                {
                    if((array)$c->image)
                    {
                        $c->image['url']='http://localhost:8000/storage/'.$c->image['file_name'];
                    }
                }
        return response()->json([
            'status' => 'success',
            'message' => 'Categories indexed successfully!',
            'categories' =>$category
            ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category=new Category;
        $category->name=$request->input('name');
        $category->slug=$request->input('slug');
        if($category->save())
        {
            return 'Category Created';
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
        $category=Category::find($id);
        return $category;
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
        $category=Category::find($id);
        $category->name=$request->input('name');
        $category->slug=$request->input('slug');
        if($category->save())
        {
            return 'Category updated';
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
        $category=Category::find($id);
        $image = $category->image;
        if($category->delete())
        {
            $image->delete();
            return 'Category deleted';
        }
        

    }
}
