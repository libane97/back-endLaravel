<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
         $category = Category::with('child','parent')->get();
         $category->makeHidden(['created_at','updated_at','parent','parent_id']);
         return response()->json(['data' => $category]);
    }


    public function store(Request $request){
         $data = $this->validatedata($request);
         $category = new Category();
         $category->name = $data['name'];
         $category->parent_id = $data['parent_id'];
         $category->save();
         return response()->json(['success'=>'category creer avec success', 'category'=>$category]);
    }

    public function show(Category $category){
         $categories = Category::find($category->id);
         $categories->child = $categories->child;
         $categories->makeHidden(['created_at','updated_at','parent','parent_id']);
         return $categories;
    }


    public function update(Category $category,Request $request){
        $data = $this->validatedata($request);
        $categories = Category::find($category->id);
        $categories->name = $data['name'];
        $categories->parent_id = $data['parent_id'];
        $categories->save();
        return response()->json(['success'=>'category modifier avec success', 'category'=>$categories]);
    }



    public function delete(Category $category)
    {
        $categories = Category::find($category->id);
        $categories->delete();
        return response()->json(['success'=>'category supprime avec success', 'category'=>$categories]);;
    }

    private function validatedata(Request $request){
        $data = $request->validate([
            'name' => 'required|min:3|max:20',
            'parent_id' => 'required',
       ]);
       return $data;
    }
}
