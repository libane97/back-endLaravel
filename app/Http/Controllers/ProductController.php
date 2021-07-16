<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(){
        $product = Product::with('categories')->get();
        foreach ($product as $products){
            $products->categories = $products->categories->makeHidden(['created_at','updated_at','parent_id']);
        }
        $product->makeHidden(['updated_at','category_id']);
        return response()->json(['data' => $product]);
    }

    public function store(Request $request){

        $product = Product::make($request->all());
        // $product = new Product();
        // $product->name = $request->input('name');
        // $product->description = $request->input('description');
        // $product->price = $request->input('price');
        // $product->reduction = $request->input('reduction');
        // $product->stock = $request->input('stock');
        // $product->disponibilite = $request->input('disponibilite');
        try {
            $product->image = 'http://127.0.0.1:8000/'.$request->file('image')->store('products');
        }
        catch(Exception $e){
            dd($e->getMessage());
            die();
        }
        $product->category_id = $request->input('category_id');
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'reduction' => 'required',
            'stock' => 'required',
            'disponibilite' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
        ]);

        $product->save();
        return response()->json(['success'=> 'Le produit à été creer avec success', 'data' => $product]);
    }


    public function show(Product $product) {
        $products = Product::find($product->id);
        $products->categories = $products->categories;
        return response()->json(['success' => 'Le produit exist', 'data' => $products]);
    }


    public function update(Request $request, Product $product){
         $products = Product::find($product->id);
         $products->name = $request->input('name');
         $products->description = $request->input('description');
         $products->price = $request->input('price');
         $products->reduction = $request->input('reduction');
         $products->stock = $request->input('stock');
         $products->disponibilite = $request->input('disponibilite');
         try {
            if($request->file('image')){
            $products->image =  'http://127.0.0.1:8000/'.$request->file('image')->store('products');
                }
         }  catch(Exception $e){
            dd($e->getMessage());
            die();
         }
         $products->category_id = $request->input('category_id');
        //  $this->validate($request,[
        //      'name' => 'required',
        //      'description' => 'required',
        //      'price' => 'required',
        //      'reduction' => 'required',
        //      'stock' => 'required',
        //      'disponibilite' => 'required',
        //      'image' => 'required',
        //      'category_id' => 'required',
        //  ]);
         $products->save();
         return response()->json(['success'=>'Le produit à été modifier avec success', 'data' => $products]);
    }



    public function delete(Product $product){
         $products = Product::find($product->id);
         Storage::delete($products->image);
         $products->delete();
         return response()->json(['success'=> 'le produit a ete supprime avec success']);
    }

    public function search($product){
        $products = Product::where('name','LIKE',"%{$product}%")->with('categories')->get();
        $products->makeHidden(['created_at','updated_at','category_id']);
        foreach($products as $prod){
            $products->categories =  $prod->categories->makeHidden(['created_at','updated_at','parent_id']);
        }
        return $products;
    }

    public function getProductByDisponible($disponibilite)
    {
        $products = Product::where('disponibilite', '=', $disponibilite)->get();
        $products->makeHidden(['created_at','updated_at','category_id']);
        foreach ($products as $product){
            $product->categories = $product->categories->makeHidden(['created_at','updated_at','parent_id']);
            $product->setFirstNameAttribute($product->name);
        }
        if ($products) {
            return $products;
        }else{
            return response()->json(['success'=> 'le produit qui sont dans cet categorie est terminer']);
        }
    }



    public function getProductByCategory(Category $category)
    {
        $products = Product::where('category_id', '=', $category->id)->get();
        $products->makeHidden(['created_at','updated_at','category_id']);
        foreach ($products as $product){
            $product->categories = $product->categories->makeHidden(['created_at','updated_at','parent_id']);
            $product->setFirstNameAttribute($product->name);
        }
        if ($products) {
            return $products;
        }else{
            return response()->json(['success'=> 'le produit qui sont dans cet categorie est terminer']);
        }
    }


    public function getProductByCategoryAndDispo(Category $category,$dispo){
        $products = Product::where('category_id', '=', $category->id)->where('disponibilite', '=',$dispo)->get();
        $products->makeHidden(['created_at','updated_at','category_id']);
        foreach ($products as $product){
            $product->categories = $product->categories->makeHidden(['created_at','updated_at','parent_id']);
            $product->setFirstNameAttribute($product->name);
        }
        if ($products) {
            return $products;
        }else{
            return response()->json(['success'=> 'le produit qui sont dans cet categorie est terminer']);
        }
    }


    private function validateData(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'reduction' => 'required',
            'stock' => 'required',
            'disponibilite' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
        ]);

       return $data;
    }
}
