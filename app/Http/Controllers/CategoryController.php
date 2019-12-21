<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;


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
        $category->name=$name;
        $category->slug=$slug;
        if($category->save())
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully!',
                'categorie' =>$category
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
        $category=Category::where('slug',$slug)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Category retrieved successfully!',
            'category' =>$category
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
        $category=Category::where('slug',$slug)->first();
        if($request->has(['name']))
        {
            $category->name=$request->input('name');
        }
        elseif ($request->has(['slug']))
        {
            $category->slug=$request->input('slug');
        }
        if($category->save())
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Category updated successfully!',
                'category' =>$category
                ]);
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
