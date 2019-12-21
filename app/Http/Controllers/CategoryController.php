<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use App;

class CategoryController extends Controller
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
        $category=Category::paginate(10);
        foreach ($category as $c)
                {
                    if((array)$c->image)
                    {
                        $c->image['url']='http://localhost:8000/storage/'.$c->image['file_name'];
                    }
                }
        return response()->json([
            'status' => __('response.status'),
            'message' => 'Categories '.__('response.message.index'),
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
        App::setLocale($this->local);
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
                'status' => __('response.status'),
                'message' => 'Categories '.__('response.message.create'),
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
        App::setLocale($this->local);
        $category=Category::where('slug',$slug)->first();
        return response()->json([
            'status' => __('response.status'),
            'message' => 'Categories '.__('response.message.show'),
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
        App::setLocale($this->local);
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
                'status' => __('response.status'),
                'message' => 'Categories '.__('response.message.update'),
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
    public function destroy($slug)
    {
        App::setLocale($this->local);
        $category=Category::where('slug',$slug)->first();
        $empty=true;
        if($category->image)
        {
            $image = $category->image;
            $empty=false;
        }
        if($category->delete())
        {
            if(!$empty)
            {
                $image->delete();
            }
            return response()->json([
                'status' => __('response.status'),
                'message' => 'Categories '.__('response.message.delete'),
                ]);
        }
    }
}
