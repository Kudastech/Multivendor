<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function products()
    {
        Session::put('page', 'products');

        $products = Product::with('section', 'category')->get()->toArray();

        return view('admin.products.products', compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();

            $status = $data['status'] == "Active" ? 0 : 1;

            Product::where('id', $data['product_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function addEditProduct(Request $request, $product = null)
    {
        if ($product == "") {
            $title = "Add Product";
            $product = new Product;
            $message = "  Product Added Successfully";
        } else {
            $title = "Edit Product";
            $message = "  Product Updated Successfully";
            $product = Product::find($product);
            // dd($product);
        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd(Auth::guard('admin')->user());

            $rules = [
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
                'category_id' => 'required',
            ];

            $customMessages = [

                'product_name.required' => 'Product Name is Required',
                'product_name.regex' => 'Valid Product Name is Required',
                'product_code.required' => 'Product Code is Required',
                'product_code.regex' => 'Valid Product Code is Required',
                'product_price.required' => 'Product Price is Required',
                'product_price.regex' => 'Valid Product Price is Required',
                'product_color.required' => 'Product Color is Required',
                'product_color.regex' => 'Valid Product Color is Required',
                'category_id.required' => 'Category ID is Required',
            ];

            $this->validate($request, $rules, $customMessages);

            // Upload product Image Resize small: 250*250 medium 500*500 large: 1000*1000
            if ($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New image name
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $largeImagePath = 'front/images/product_images/large/' . $imageName;
                    $mediumImagePath = 'front/images/product_images/medium/' . $imageName;
                    $smallImagePath = 'front/images/product_images/small/' . $imageName;
                    // Upload the Large Medium and small Image
                    Image::make($image_tmp)->resize(1000,1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500,500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250,250)->save($smallImagePath);
                    // Insert Image Name in Product Table
                    $product->product_image = $imageName;
                }
            }

            // Uploda Product Video

            if($request->hasFile('product_video'))
            {
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid())
                {
                    // upload the Video

                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111, 99999).'.'.$extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath,$videoName);
                    // Insert Video Name in product table
                    $product->product_video = $videoName;

                }
            }

            // save Product details on Product Table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id = Auth::guard('admin')->user()->id;

            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;
            if ($adminType == "vendor") {
                $product->vendor_id = $vendor_id;
            } else {
                $product->vendor_id = 0;
            }
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_weight = $data['product_weight'];
            $product->product_discount = $data['product_discount'];
            $product->product_description = $data['product_description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();

            return redirect('admin/products')->with('success_message', $message);
        }


        // Get Section with ctategories
        $categories = Section::with('categories')->get()->toArray();

        // Get all Brands
        $brands = Brand::where('status', 1)->get()->toArray();

        // dd($categories);

        return view('admin.products.add_edit_product')->with(compact('title', 'categories', 'brands', 'product'));
    }

    public function deleteProduct($product)
    {
        // Delete Products

        Product::where('id', $product)->delete();

        return redirect()->back()->with('success_message', 'Product has been deleted successfully');
    }

    public function deleteProductImage($product)
    {
        $productImage = Product::select('product_image')->where('id', $product)->first();

        // Get Product Image Path
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

            // delete product small image folder

        if(file_exists($small_image_path.$productImage->product_image))
        {
            unlink($small_image_path.$productImage->product_image);
        }
            // delete product medium image folder

        if(file_exists($medium_image_path.$productImage->product_image))
        {
            unlink($medium_image_path.$productImage->product_image);
        }
        // delete product Large image folder

        if(file_exists($large_image_path.$productImage->product_image))
        {
            unlink($large_image_path.$productImage->product_image);
        }

        // Delete the products the image from the product table
        Product::where('id', $product)->update(['product_image'=>'']);

        return redirect()->back()->with('success_message', 'Product Image has been deleted successfully');

    }

    public function deleteProductVideo($product)
    {
        // Get Product video

        $productVideo = Product::select('product_video')->where('id', $product)->first();

        // Get Product Video Path

        $product_video_path = 'front/videos/product_videos/';

        // delete Product video from Product table
        if(file_exists($product_video_path.$productVideo->product_video))
        {
            unlink($product_video_path.$productVideo->product_video);
        }
        Product::where('id', $product)->update(['product_video'=> '']);

        return redirect()->back()->with('success_message', 'Product Video has been deleted successfully');

    }

    public function addEditAttributes(Request $request, $attribute)
    {
        $product = Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($attribute);
        // $product = json_decode(json_encode($product), true);
        // dd($product);

        if($request->isMethod('post'))
        {

        $data = $request->all();

        foreach($data['sku'] as $key => $value)
        {
            if(!empty($value))
            {

                // SKU DUPLICATE CHECK
                $skuCount = ProductAttribute::where('sku', $value)->count();
                if($skuCount>0)
                {
                    return back()->with('error_message', 'SKU already exist! Please add another SKU!');
                }

                // Size duplicate check
                $sizeCount = ProductAttribute::where(['product_id'=>$attribute,'size'=>$data['size'][$key]])->count();
                if($sizeCount>0){
                    return redirect()->back()->with('error_message','Size already exists! Please add another Size!');
                }

                $attributes = new ProductAttribute;
                $attributes->product_id = $attribute;
                $attributes->sku = $value;
                $attributes->size = $data['size'][$key];
                $attributes->price = $data['price'][$key];
                $attributes->stock = $data['stock'][$key];
                $attributes->status = 1;
                $attributes->save();

            }
        }

        return back()->with('success_message', 'Product Attribute has been added Successfully!');

    }

        return view('admin.attribute.add_edit_attributes')->with(compact('product'));
    }


    public function updateAttributeStatus(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();

            $status = $data['status'] == "Active" ? 0 : 1;

            ProductAttribute::where('id', $data['attribute_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'attribute_id' => $data['attribute_id']]);
        }
    }
}
