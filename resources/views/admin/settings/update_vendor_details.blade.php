@extends('admin.layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Update Vendor Details</h3>
                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="justify-content-end d-flex">
                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button"
                                        id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="true">
                                        <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                        <a class="dropdown-item" href="#">January - March</a>
                                        <a class="dropdown-item" href="#">March - June</a>
                                        <a class="dropdown-item" href="#">June - August</a>
                                        <a class="dropdown-item" href="#">August - November</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($slug == 'personal')
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Update Personal Information</h4>
                                @if (Session::has('error_message'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error: </strong> {{ Session::get('error_message') }}
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button> --}}
                                    </div>
                                @endif
                                @if (Session::has('success_message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success: </strong> {{ Session::get('success_message') }}
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button> --}}
                                    </div>
                                @endif
                                <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}"
                                    method="post" name="updateAdminPasswordForm" id="updateAdminPasswordForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="text">Vendor Username/Email</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ Auth::guard('admin')->user()->email }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="vendor_name">Name</label>
                                        <input type="text" class="form-control" name="vendor_name" id="vendor_name"
                                            placeholder="Enter Vendor Name"
                                            value="{{ Auth::guard('admin')->user()->name }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('vendor_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <label for="vendor_address">Address</label>
                                        <input type="text" class="form-control" name="vendor_address" id="vendor_address"
                                            placeholder="Enter Vendor Address" value="{{ $vendorDetails['address'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('vendor_address')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_city">City</label>
                                        <input type="text" class="form-control" name="vendor_city" id="vendor_city"
                                            placeholder="Enter Vendor City" value="{{ $vendorDetails['city'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('vendor_city')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_state">State</label>
                                        <input type="text" class="form-control" name="vendor_state" id="vendor_state"
                                            placeholder="Enter Vendor State" value="{{ $vendorDetails['state'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('vendor_state')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_country">Country</label>
                                        <select name="vendor_country" id="vendor_country" class="form-control" style="color: #495057;">
                                            <option value=""> Select Country </option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country['country_name'] }}" @if($country['country_name'] == $vendorDetails['country']) selected @endif>{{ $country['country_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_pincode">Pincode</label>
                                        <input type="text" class="form-control" name="vendor_pincode" id="vendor_pincode"
                                            placeholder="Enter Vendor Pincode" value="{{ $vendorDetails['pincode'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('vendor_pincode')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="vendor_mobile">Mobile</label>
                                        <input type="text" class="form-control" name="vendor_mobile"
                                            id="vendor_mobile" placeholder="Enter Vendor Mobile"
                                            value="{{ $vendorDetails['mobile'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('vendor_mobile')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <label for="vendor_image">Image</label>
                                        <input type="file" class="form-control" name="vendor_image" id="vendor_image"
                                            placeholder="Enter Vendor Image">

                                        @if (!empty(Auth::guard('admin')->user()->image))
                                            <a target="_blank"
                                                href="{{ url('admin/images/photos/' . Auth::guard('admin')->user()->image) }}">View
                                                Image</a>
                                            <input type="hidden" name="current_vendor_image"
                                                value="{{ Auth::guard('admin')->user()->image }}">
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($slug == 'business')
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Update Business Information</h4>
                                @if (Session::has('error_message'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error: </strong> {{ Session::get('error_message') }}
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button> --}}
                                    </div>
                                @endif
                                @if (Session::has('success_message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success: </strong> {{ Session::get('success_message') }}
                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button> --}}
                                    </div>
                                @endif
                                <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}"
                                    method="post" name="updateAdminPasswordForm" id="updateAdminPasswordForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="text">Vendor Username/Email</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ Auth::guard('admin')->user()->email }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="shop_name">Shop Name</label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name"
                                            placeholder="Enter Shop Name" value="{{ $vendorDetails['shop_name'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('shop_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <label for="vendor_address">Shop Address</label>
                                        <input type="text" class="form-control" name="shop_address" id="shop_address"
                                            placeholder="Enter Shop Address"
                                            value="{{ $vendorDetails['shop_address'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('shop_address')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_city"> Shop City</label>
                                        <input type="text" class="form-control" name="shop_city" id="shop_city"
                                            placeholder="Enter Shop City" value="{{ $vendorDetails['shop_city'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('shop_city')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_state">Shop State</label>
                                        <input type="text" class="form-control" name="shop_state" id="shop_state"
                                            placeholder="Enter Shop State" value="{{ $vendorDetails['shop_state'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('shop_state')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_country">Shop Country</label>
                                        <select name="shop_country" id="shop_country" class="form-control" style="color: #495057;">
                                            <option value=""> Select Country </option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country['country_name'] }}" @if($country['country_name'] == $vendorDetails['shop_country']) selected @endif>{{ $country['country_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="shop_pincode">Shop Pincode</label>
                                        <input type="text" class="form-control" name="shop_pincode" id="shop_pincode"
                                            placeholder="Enter Shop Pincode"
                                            value="{{ $vendorDetails['shop_pincode'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('shop_pincode')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <label for="shop_mobile">Shop Mobile</label>
                                        <input type="text" class="form-control" name="shop_mobile" id="shop_mobile"
                                            placeholder="Enter Shop Mobile" value="{{ $vendorDetails['shop_mobile'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('shop_mobile')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="business_license_number">Business License Number</label>
                                        <input type="text" class="form-control" name="business_license_number"
                                            id="business_license_number" placeholder="Enter Business License Number"
                                            value="{{ $vendorDetails['business_license_number'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('business_license_number')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="gst_number">GST Number</label>
                                        <input type="text" class="form-control" name="gst_number" id="gst_number"
                                            placeholder="Enter GST Number" value="{{ $vendorDetails['gst_number'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('gst_number')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="pan_number">Shop Pan Number </label>
                                        <input type="text" class="form-control" name="pan_number" id="pan_number"
                                            placeholder="Enter Pan Number" value="{{ $vendorDetails['pan_number'] }}">
                                        {{-- <span id="check_password"></span> --}}
                                        <span class="text-danger">
                                            @error('pan_number')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_proof">Address proof</label>
                                        <select name="address_proof" id="address_proof" class="form-control">
                                            <option value="Passport" @if ($vendorDetails['address_proof'] == 'Passport') selected @endif>
                                                Passport</option>
                                            <option value="Voting card" @if ($vendorDetails['address_proof'] == 'Voting card') selected @endif>
                                                Voting card</option>
                                            <option value="Driving licence"
                                                @if ($vendorDetails['address_proof'] == 'Driving licence') selected @endif>Drivig Licence</option>
                                            <option value="NIN" @if ($vendorDetails['address_proof'] == 'NIN') selected @endif>NIN
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address_proof_image">Addess Proof Image</label>
                                        <input type="file" class="form-control" name="address_proof_image"
                                            id="address_proof_image" placeholder="Enter Address Proof Image">
                                        @if (!empty($vendorDetails['address_proof_image']))
                                            <a target="_blank"
                                                href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">View
                                                Image</a>
                                            <input type="hidden" name="current_shop_image"
                                                value="{{ $vendorDetails['address_proof_image'] }}">
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($slug == 'bank')
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Update Personal Information</h4>
                            @if (Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error: </strong> {{ Session::get('error_message') }}
                                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button> --}}
                                </div>
                            @endif
                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong> {{ Session::get('success_message') }}
                                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button> --}}
                                </div>
                            @endif
                            <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}"
                                method="post" name="updateAdminPasswordForm" id="updateAdminPasswordForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="text">Vendor Username/Email</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ Auth::guard('admin')->user()->email }}">
                                </div>

                                <div class="form-group">
                                    <label for="vendor_address">Account Holder Name</label>
                                    <input type="text" class="form-control" name="account_holder_name" id="account_holder_name"
                                        placeholder="Enter Account Holder Name" value="{{ $vendorDetails['account_holder_name'] }}">
                                    {{-- <span id="check_password"></span> --}}
                                    <span class="text-danger">
                                        @error('account_holder_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name" id="bank_name"
                                        placeholder="Enter Bank Name" value="{{ $vendorDetails['bank_name'] }}">
                                    {{-- <span id="check_password"></span> --}}
                                    <span class="text-danger">
                                        @error('bank_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="account_number">Account Number</label>
                                    <input type="text" class="form-control" name="account_number" id="account_number"
                                        placeholder="Enter Account Number" value="{{ $vendorDetails['account_number'] }}">
                                    {{-- <span id="check_password"></span> --}}
                                    <span class="text-danger">
                                        @error('account_number')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="bank_ifsc_code">Bank Code</label>
                                    <input type="text" class="form-control" name="bank_ifsc_code" id="bank_ifsc_code"
                                        placeholder="Enter Bank Code" value="{{ $vendorDetails['bank_ifsc_code'] }}">
                                    {{-- <span id="check_password"></span> --}}
                                    <span class="text-danger">
                                        @error('bank_ifsc_code')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @include('admin.layout.footer')
        <!-- partial -->
    </div>
@endsection
