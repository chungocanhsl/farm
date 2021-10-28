<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Storage;
use Session;
use App\Cart;
use Illuminate\Support\Facades\Redirect;


class ProductController extends Controller
{
    //
    public function addproduct() {
        $categories = Category::All()->pluck('category_name','category_name');

        return view('admin.addproduct')->with('categories',$categories);

    }


    public function saveproduct(Request $request) {

        //print ($request->input('product_category'));

        $this->validate($request, ['product_name' => 'required',
            'product_price' => 'required',
            'product_image' => 'image|nullable|max:1999',
        ]);

        if($request->input('product_category')) {

            if($request->hasFile('product_image')) {
                //1. get filename with ext
                $filNameWithExt = $request->file('product_image')->getClientOriginalName();

                //2. get just file name
                $fileName = pathinfo($filNameWithExt,PATHINFO_FILENAME);

                //3. get just extension
                $extension = $request->file('product_image')->getClientOriginalExtension();

                //4. file name to store
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;

                //upload image
                $path = $request->file('product_image')-> storeAs('public/product_images',
                    $fileNameToStore);

            } else {
                $fileNameToStore ='noimage.jpg';
            }

            $product = new Product();
            $product->product_name = $request->input('product_name');
            $product->product_price = $request->input('product_price');
            $product->product_category = $request->input('product_category');
            $product->product_image = $fileNameToStore;
            $product->product_status = 1;



            $product->save();

            return redirect('/addproduct')->with('status','The '.$product->product_name . ' product has been saved successfully');

        } else {
            return redirect('/addproduct')->with('status1','Do select the category please');

        }




    }
    public function products() {
        $products = Product::get();

        return view('admin.products')->with('products',$products);

    }

    public function editproduct(Request $request, $id) {
        $categories = Category::All()->pluck('category_name','category_name');

        $product = Product::find($id);



        return view('admin.editproduct')->with('product',$product)->with('categories',$categories);

    }

    public function updateproduct(Request $request) {

        $this->validate($request, ['product_name' => 'required',
                                    'product_price' => 'required',
                                     'product_image' => 'image|nullable|max:1999',
                                    ]);

        $product = Product::find($request->input('id'));

        $product->product_name = $request->input('product_name');
        $product->product_price = $request->input('product_price');
        $product->product_category = $request->input('product_category');

        if($request->hasFile('product_image')) {
            //1. get filename with ext
            $filNameWithExt = $request->file('product_image')->getClientOriginalName();

            //2. get just file name
            $fileName = pathinfo($filNameWithExt,PATHINFO_FILENAME);

            //3. get just extension
            $extension = $request->file('product_image')->getClientOriginalExtension();

            //4. file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            //upload image
            $path = $request->file('product_image')-> storeAs('public/product_images',
                $fileNameToStore);

            //$old_image->product_image = Product::find($request->input('id'));

            if($product->product_image != 'noimage.jpg') {
                Storage::delete('public/product_images/'.$product->product_image);
            }

            $product->product_image = $fileNameToStore;
        }

        $product->update();

        return redirect('/products')->with('status','The '.$product->product_name . ' product has been updated successfully');

    }

    public function delete_product($id) {

        $product=Product::find($id);

        if($product->product_image != 'noimage.jpg') {
            Storage::delete('public/product_images/'.$product->product_image);
        }

        $product->delete();

        return redirect('/products')->with('status','The '.$product->product_name . ' product has been deleted successfully');

    }

    public function activate_product($id) {
        $product = Product::find($id);

        $product->product_status = 1;

        $product->update();

        return redirect('/products')->with('status','The '.$product->product_name . ' product status has been activated successfully');

    }

    public function unactivate_product($id) {
        $product = Product::find($id);

        $product->product_status = 0;

        $product->update();

        return redirect('/products')->with('status','The '.$product->product_name . ' product status has been unactivated successfully');


    }

    public function addToCart($id) {
        $product = Product::find($id);

        //print_r($product);

        $oldCart = Session::has('cart')? Session::get('cart'): null;
        $cart = new Cart($oldCart);
        $cart->add($product,$id);
        Session::put('cart',$cart);

        //dd(Session::get('cart'));
        return redirect::to('/shop');
    }




}
