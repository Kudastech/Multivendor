<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use Image;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function categories()
    {

        Session::put('page', 'categories');

        $categories = Category::with('section', 'parentcategory')->get()->toArray();

        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
             $status = $data['status'] == "Active" ? 0 : 1 ;

            Category::where('id', $data['category_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id = null)
    {
        if ($id == "") {
            // Add Category functionality
            $title = "Add Category";
            $category = new Category;
            $getCategories = array();
            $message = "  Category Added Successfully";
        } else {
            // Edit Category Functionality

            $title = "Edit Category";
            $category = Category::find($id);
            $getCategories = Category::with('subCategories')->where(['parent_id' => 0, 'section_id' => $category['section_id']])->get();
            // dd($category['category_name']);
            $message = "  Category Updated Successfully";
        }
        if ($request->isMethod('post')) {
            $imageName = "";
            $data = $request->all();

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ];

            $customMessages = [

                'category_name.required' => 'Category Name is Required',
                'category_name.regex' => 'Valid Category Name is Required',
                'section_id.required' => 'Section ID is Required',
                'url.required' => 'Category URL is Required',
            ];

            $this->validate($request, $rules, $customMessages);
        if($data['category_discount']=="")
        {
            $data['category_discount'] = 0;
        }
            // Upload Category Image
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate New image name

                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'front/images/category_images/' . $imageName;

                    // Upload The Image
                    Image::make($image_tmp)->save($imagePath);

                    $category->category_image = $imageName;
                }
            } else {
                $category->category_image = $imageName;
            }

            $category->category_name = $data['category_name'];
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->url = $data['url'];
            $category->description = $data['description'];
            $category->category_discount = $data['category_discount'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message', $message);
        }
        // Get all sections
        $getSections = Section::get()->toArray();

        return view('admin.categories.add_edit_category')->with(compact('title', 'category', 'getSections', 'getCategories'));
    }

    public function appendCategoryLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $getCategories = Category::with('subCategories')->where(['parent_id' => 0, 'section_id' => $data['section_id']])->get()->toArray();

            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategory($id)
    {
        // Delete category

        Category::where('id',$id)->delete();

        $message = "Category has been deleted successfully";

        return redirect()->back()->with('success_message', $message);
    }

    public function deleteCategoryImage($id)
    {
        // Get the Category Image

        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        // Get category Image Path

        $category_image_path = 'front/images/category_images/';

        // Delete the Category Image From category_image Folder if Exist

        if(file_exists($category_image_path.$categoryImage->category_image))
        {
            unlink($category_image_path.$categoryImage->category_image);
        }

        // Delete Category Image From Categories Folders

        Category::where('id', $id)->update(['category_image'=>'']);

        return redirect()->back()->with('success_message', 'Category Image has been deleted successfully');
    }
}
