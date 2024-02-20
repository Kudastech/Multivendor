<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function categories() {

        Session::put('page','categories');

        $categories = Category::with('section', 'parentCategory')->get()->toArray();

        // dd($categories);

        return view('admin.categories.categories')->with(compact('categories'));

    }

    public function updateCategoryStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            if($data['status']=="Active")
            {
                $status = 0;
            }else{
                $status = 1;
            }

            Category::where('id',$data['category_id'])->update(['status'=>$status]);

            return response()->json(['status'=> $status, 'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory($id=null)
    {
        if($id=="")
        {
            // Add Category functionality
            $title = "Add Category";
            $category = new Category;
            $message ="  Category Added Successfully";
        }
        else
        {
            // Edit Category Functionality

            $title = "Edit Category";
            $category = Category::find($id);
            $message ="  Category Updated Successfully";
        }
        // Get all sections
        $getSections = Section::get()->toArray();
        return view('admin.categories.add_edit_category')->with(compact('title','category','getSections'));
    }
}
