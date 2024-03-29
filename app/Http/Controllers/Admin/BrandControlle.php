<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function brands()
    {
        Session::put('page','brands');

        $brands = Brand::get()->toArray();

        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function updateBrandStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            
             $status = $data['status'] == "Active" ? 0 : 1 ;
            
            Brand::where('id',$data['brand_id'])->update(['status'=>$status]);

            return response()->json(['status'=> $status, 'brand_id'=>$data['brand_id']]);
        }
    }

    public function deleteBrand($id)
    {
        Brand::where('id',$id)->delete();

        return redirect()->back()->with('success_message', 'Brand has been deleted successfully');
    }

    public function addEditBrand(Request $request, $id=null)
    {
        Session::put('page','brands');
        if($id=="")
        {
            $title = "Add Brand";
            $brand = new Brand;
            $message = "Brand added successfully!";
        }
        else{
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = "Brand Updated successfully!";
        }
        if($request->isMethod('post'))
        {
            $data = $request->all();

            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u|unique:brands,name',
            ];

            $customMessages = [

                'brand_name.required' => 'Brand Name is Required',
                'brand_name.regex' => 'Valid Brand Name is Required',

            ];

            $this->validate($request, $rules, $customMessages);

            $brand->name = $data['brand_name'];
            $brand->status = 1;
            $brand->save();

            return redirect('admin/brands')->with('success_message', $message);
        }

        return view('admin.brands.add_edit_brand')->with(compact('title', 'brand'));

    }
}
