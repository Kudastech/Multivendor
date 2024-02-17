@extends('admin.layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Vendor Details</h3>
                            {{-- <h6 class="font-weight-normal mb-0 mt-0"> <a  class="btn btn-primary" href="{{ url('admin/admins/vendor') }}">Back to Vendor</a></h6> --}}

                        </div>
                        <div class="col-12 col-xl-4">
                            <div class="justify-content-end d-flex">
                                <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                    <h6 class="font-weight-normal mb-0 mt-0"> <a  class="btn btn-primary float-right" href="{{ url('admin/admins/vendor') }}">Back to Vendor</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Personal Information</h4>


                            <div class="form-group">
                                <label for="text">Email</label>
                                <input type="text" class="form-control" readonly
                                    value="{{ $vendorDetails['vendor_personal']['email'] }}">
                            </div>

                            <div class="form-group">
                                <label for="vendor_name">Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name"
                                    value="{{ $vendorDetails['vendor_personal']['name'] }}" readonly>

                            </div>

                            <div class="form-group">
                                <label for="vendor_address">Address</label>
                                <input type="text" class="form-control" name="vendor_address"
                                    value="{{ $vendorDetails['vendor_personal']['address'] }}" readonly>

                            </div>
                            <div class="form-group">
                                <label for="vendor_city">City</label>
                                <input type="text" class="form-control" name="vendor_city"
                                    value="{{ $vendorDetails['vendor_personal']['city'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_state">State</label>
                                <input type="text" class="form-control" name="vendor_state"
                                    value="{{ $vendorDetails['vendor_personal']['state'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_country">Country</label>
                                <input type="text" class="form-control" name="vendor_country"
                                    value="{{ $vendorDetails['vendor_personal']['country'] }}" readonly>
                                    </div>

                                    <div class="form-group">
                                <label for="vendor_pincode">Pincode</label>
                                <input type="text" class="form-control" name="vendor_pincode"
                                    value="{{ $vendorDetails['vendor_personal']['pincode'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Mobile</label>
                                <input type="text" class="form-control" name="vendor_mobile"
                                    value="{{ $vendorDetails['vendor_personal']['mobile'] }}" readonly>
                            </div>

                            @if (!empty($vendorDetails['image']))
                            <div class="form-group">
                                <label for="vendor_image">Image</label>
                                <br>

                                    <img target="_blank" style="width:100px;"
                                        src="{{ url('admin/images/photos/' . $vendorDetails['image']) }}">

                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Business Information</h4>

                            <div class="form-group">
                                <label for="vendor_name">Shop Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name"
                                    value="{{ $vendorDetails['vendor_business']['shop_name'] }}" readonly>

                            </div>

                            <div class="form-group">
                                <label for="vendor_address">Shop Address</label>
                                <input type="text" class="form-control" name="vendor_address"
                                    value="{{ $vendorDetails['vendor_business']['shop_address'] }}" readonly>

                            </div>
                            <div class="form-group">
                                <label for="vendor_city">Shop City</label>
                                <input type="text" class="form-control" name="vendor_city"
                                    value="{{ $vendorDetails['vendor_business']['shop_city'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_state">Shop State</label>
                                <input type="text" class="form-control" name="vendor_state"
                                    value="{{ $vendorDetails['vendor_business']['shop_state'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_country">Shop Country</label>
                                <input type="text" class="form-control" name="vendor_country"
                                    value="{{ $vendorDetails['vendor_business']['shop_country'] }}" readonly>
                                    </div>

                                    <div class="form-group">
                                <label for="vendor_pincode">Shop Pincode</label>
                                <input type="text" class="form-control" name="vendor_pincode"
                                    value="{{ $vendorDetails['vendor_business']['shop_pincode'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Shop Mobile</label>
                                <input type="text" class="form-control" name="vendor_mobile"
                                    value="{{ $vendorDetails['vendor_business']['shop_mobile'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Shop Website</label>
                                <input type="text" class="form-control" name="vendor_mobile"
                                    value="{{ $vendorDetails['vendor_business']['shop_website'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Shop Email</label>
                                <input type="text" class="form-control" name="vendor_mobile"
                                    value="{{ $vendorDetails['vendor_business']['shop_email'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Business License Number</label>
                                <input type="text" class="form-control" name="vendor_mobile"
                                    value="{{ $vendorDetails['vendor_business']['business_license_number'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">GST</label>
                                <input type="text" class="form-control" name="vendor_mobile"
                                    value="{{ $vendorDetails['vendor_business']['gst_number'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Pan Number</label>
                                <input type="text" class="form-control" name="vendor_mobile"
                                    value="{{ $vendorDetails['vendor_business']['pan_number'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_mobile">Address Proof</label>
                                <input type="text" class="form-control" name="vendor_mobile"
                                    value="{{ $vendorDetails['vendor_business']['address_proof'] }}" readonly>
                            </div>


                            @if (!empty($vendorDetails['vendor_business']['address_proof_image']))
                            <div class="form-group">
                                <label for="vendor_image">Image</label>
                                <br>

                                    <img target="_blank" style="width:100px;"
                                        src="{{ url('admin/images/proofs/'. $vendorDetails['vendor_business']['address_proof_image']) }}">

                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Bank Information</h4>

                            <div class="form-group">
                                <label for="vendor_name">Account Holder Name</label>
                                <input type="text" class="form-control" name="vendor_name" id="vendor_name"
                                    value="{{ $vendorDetails['vendor_bank']['account_holder_name'] }}" readonly>

                            </div>

                            <div class="form-group">
                                <label for="vendor_address">Bank Name</label>
                                <input type="text" class="form-control" name="vendor_address"
                                    value="{{ $vendorDetails['vendor_bank']['bank_name'] }}" readonly>

                            </div>
                            <div class="form-group">
                                <label for="vendor_city">Account Number</label>
                                <input type="text" class="form-control" name="vendor_city"
                                    value="{{ $vendorDetails['vendor_bank']['account_number'] }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="vendor_state">Bank Code</label>
                                <input type="text" class="form-control" name="vendor_state"
                                    value="{{ $vendorDetails['vendor_bank']['bank_ifsc_code'] }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @include('admin.layout.footer')
        <!-- partial -->
    </div>
@endsection
