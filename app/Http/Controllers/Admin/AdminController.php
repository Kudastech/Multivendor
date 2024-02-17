<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Models\Admin;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\VendorsBankDetail;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\VendorsBusinessDetail;
use Illuminate\Support\Facades\Session;
use App\Models\VendorsBusinessBankDetail;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page','dashboard');

        return view('admin.dashboard');
    }

    public function updateAdminPassword(Request $request)
    {
        Session::put('page','update_admin_password');

        if ($request->isMethod('post')) {
            $data = $request->all();

            // echo "<pre>"; print_r($data); die;

            // check if current password entered by admin is correct

            if (hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                // chech if new password is matching with the confirmination password

                if ($data['new_password'] == $data['confirm_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);

                    return redirect()->back()->with('success_message', 'password has been updated successfully!');
                } else {
                    return redirect()->back()->with('error_message', 'New password and Confirm Password not match!');
                }
            } else {

                return redirect()->back()->with('error_message', 'Your current password is incorrect!');
            }
        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password', compact('adminDetails'));
    }


    public function checkAdminPassword(Request $request)
    {
        $data = $request->all();


        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }


    public function updateAdminDetails(Request $request)
    {
        Session::put('page','update_admin_details');

        if ($request->isMethod('post')) {

            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric'
            ];

            $customMessages = [

                'admin_name.required' => 'Admin Name is Required',
                'admin_name.regex' => 'Valid Admin Name is Required',
                'admin_mobile.required' => 'Admin Mobile is Required',
                'admin_mobile.numeric' => 'Valid Admin Mobile is Required'
            ];

            $this->validate($request, $rules, $customMessages);
            // Upload admin image

            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate New image name

                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'admin/images/photos/' . $imageName;

                    // Upload The Image
                    Image::make($image_tmp)->save($imagePath);
                }
            } else if (!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            } else {
                $imageName = "";
            }

            // Update Admin details

            Admin::where('id', Auth::guard('admin')->user()->id)

                ->update([
                    'name' => $data['admin_name'],
                    'mobile' => $data['admin_mobile'],
                    'image' => $imageName,

                ]);

            return redirect()->back()->with('success_message', 'Admin Details Updated Successfully!');
        }
        return view('admin.settings.update_admin_details');
    }





    // Updating Vendor Details.

    public function updateVendorDetails($slug, Request $request)
    {

        if ($slug == "personal") {

            Session::put('page','update_personal_details');

            if ($request->isMethod('post')) {
                $data = $request->all();

                $rules = [
                    'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_mobile' => 'required|numeric'
                ];

                $customMessages = [

                    'vendor_name.required' => 'Vendor Name is Required',
                    'vendor_city.required' => 'Vendor City is Required',
                    'vendor_name.regex' => 'Valid Vendor Name is Required',
                    'vendor_city.regex' => 'Valid Vendor City is Required',
                    'vendor_mobile.required' => 'Vendor Mobile is Required',
                    'vendor_mobile.numeric' => 'Valid Vendor Mobile is Required'
                ];

                $this->validate($request, $rules, $customMessages);
                // Upload admin image

                if ($request->hasFile('vendor_image')) {
                    $image_tmp = $request->file('vendor_image');
                    if ($image_tmp->isValid()) {
                        // Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();

                        // Generate New image name

                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/photos/' . $imageName;

                        // Upload The Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                } else if (!empty($data['current_vendor_image'])) {
                    $imageName = $data['current_vendor_image'];
                } else {
                    $imageName = "";
                }

                // Update in Admins table

                Admin::where('id', Auth::guard('admin')->user()->id)

                    ->update([
                        'name' => $data['vendor_name'],
                        'mobile' => $data['vendor_mobile'],
                        'image' => $imageName,

                    ]);

                // Update in the vendor table

                Vendor::where('id', Auth::guard('admin')->user()->vendor_id)
                    ->update([
                        'name' => $data['vendor_name'],
                        'mobile' => $data['vendor_mobile'],
                        'address' => $data['vendor_address'],
                        'city' => $data['vendor_city'],
                        'state' => $data['vendor_state'],
                        'country' => $data['vendor_country'],
                        'pincode' => $data['vendor_pincode'],
                        // 'name' => $data['vendor_name'],
                        // 'mobile' => $data['vendor_mobile'],
                        'image' => $imageName,

                    ]);

                return redirect()->back()->with('success_message', 'Vendor Details Updated Successfully!');

                // echo "<pre>"; print_r($data); die;
            }

            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        } else if ($slug == "business") {

            Session::put('page','update_business_details');

            if ($request->isMethod('post')) {

                $data = $request->all();

                $rules = [
                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile' => 'required|numeric',
                    'address_proof' => 'required',
                ];

                $customMessages = [

                    'shop_name.required' => 'Vendor Name is Required',
                    'shop_city.required' => 'Vendor City is Required',
                    'shop_name.regex' => 'Valid Vendor Name is Required',
                    'shop_city.regex' => 'Valid Vendor City is Required',
                    'shop_mobile.required' => 'Vendor Mobile is Required',
                    'address_proof.required' => 'Vendor Address Proof is Required',
                    'shop_mobile.numeric' => 'Valid Vendor Mobile is Required'
                ];

                $this->validate($request, $rules, $customMessages);
                // Upload admin image

                if ($request->hasFile('address_proof_image')) {
                    $image_tmp = $request->file('address_proof_image');
                    if ($image_tmp->isValid()) {
                        // Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();

                        // Generate New image name

                        $imageName = rand(111, 99999) . '.' . $extension;
                        $imagePath = 'admin/images/proofs/' . $imageName;

                        // Upload The Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                } else if (!empty($data['current_address_proof'])) {
                    $imageName = $data['current_address_proof'];
                } else {
                    $imageName = "";
                }

                // Update in the vendor table

                VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)
                    ->update([
                        'shop_name' => $data['shop_name'],
                        'shop_mobile' => $data['shop_mobile'],
                        'shop_address' => $data['shop_address'],
                        'shop_city' => $data['shop_city'],
                        'shop_state' => $data['shop_state'],
                        'shop_country' => $data['shop_country'],
                        'shop_pincode' => $data['shop_pincode'],
                        'shop_mobile' => $data['shop_mobile'],
                        'address_proof' => $data['address_proof'],
                        // 'address_proof_image' => $data['address_proof_image'],
                        'business_license_number' => $data['business_license_number'],
                        'gst_number' => $data['gst_number'],
                        'pan_number' => $data['pan_number'],
                        // 'name' => $data['vendor_name'],
                        // 'mobile' => $data['vendor_mobile'],
                        'address_proof_image' => $imageName,

                    ]);

                return redirect()->back()->with('success_message', 'Vendor Details Updated Successfully!');

                // echo "<pre>"; print_r($data); die;
            }

            $vendorDetails = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        } else if ($slug == "bank") {

            Session::put('page','update_bank_details');

            if ($request->isMethod('post')) {

                $data = $request->all();

                $rules = [
                    'bank_name' => 'required',

                    'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',

                    'account_number' => 'required|numeric',

                    'bank_ifsc_code' => 'required',
                ];
                $customMessages = [
                    'bank_name.required' => 'Bank Name is Required',

                    'account_holder_name.required' => 'Account Holder Name is Required',

                    'account_holder_name.regex' => 'Account Holder Name is Required',

                    'account_number.required' => 'Vendor Mobile is Required',

                    'account_number.numeric' => 'Valid Account Number is Required',

                    'bank_ifsc_code.required' => 'Bank IFSC Code is Required',
                ];

                $this->validate($request, $rules, $customMessages);

                // Update in the vendor table

                VendorsBusinessBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)
                    ->update([
                        'account_holder_name' => $data['account_holder_name'],
                        'bank_name' => $data['bank_name'],
                        'account_number' => $data['account_number'],
                        'bank_ifsc_code' => $data['bank_ifsc_code'],
                    ]);

                return redirect()->back()->with('success_message', 'Bank Details Updated Successfully!');

                // echo "<pre>"; print_r($data); die;
            }

            $vendorDetails = VendorsBusinessBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }

        $countries = Country::where('status', 1)->get()->toArray();

        return view('admin.settings.update_vendor_details')->with(compact('slug', 'vendorDetails', 'countries'));
    }
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {

            $data = $request->all();

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required'
            ];

            $customMessages = [

                'email.required' => 'Email Address is required!',
                'email.email' => 'Valid Email Address is required',
                'password.required' => 'Password is required',
            ];

            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt([
                'email' => $data['email'],
                'password' => $data['password'],
                'status' => 1
            ])) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'Invalid Email or Password');
            }
        }
        return view('admin.login');
    }

    public function admins($type=null)
    {

        $admins = Admin::query();

        if(!empty($type))
        {
            $admins = $admins->where('type',$type);

            $title = ucfirst($type)."s";

            Session::put('page','view_'.strtolower($title));

        }
        else{

        $title= "All Admins/Subamins/Vendors";

        Session::put('page','view_all');

        }
        $admins = $admins->get()->toArray();

        // dd($admins);
        return view('admin.admins.admins')->with(compact('admins','title'));

    }

    public function viewVendorDetails($id)
    {
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id', $id)->first();

        $vendorDetails = json_decode(json_encode($vendorDetails), true);

        // dd($vendorDetails);

        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            // die;
            if($data['status']=="Active")
            {
                $status = 0;
            }else{
                $status = 1;
            }

            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);

            return response()->json(['status'=> $status, 'admin_id'=>$data['admin_id']]);
        }

    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }
}
