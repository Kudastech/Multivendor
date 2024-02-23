@extends('admin.layout.layout')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                            <h3 class="font-weight-bold">Category</h3>
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
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error: </strong> {{ Session::get('error_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            </div>
                        @endif
                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success: </strong> {{ Session::get('success_message') }}
                                {{-- <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button> --}}
                            </div>
                        @endif
                        <form class="forms-sample" @if(empty($category['id'])) action="{{ url('admin/add-edit-category') }}" @else action="{{ url('admin/add-edit-category/'.$category['id']) }}"  @endif method="post"
                            name="updateAdminPasswordForm" id="updateAdminPasswordForm" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control" name="category_name" id="category_name"
                                    placeholder="Enter category Name" @if(!empty($category['category_name'])) value="{{ $category['category_name']}}" @else value="{{ old('category_name') }}" @endif >
                                <span class="text-danger">
                                    @error('category_name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="section_id">Select Section</label>
                                <select name="section_id" id="section_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($getSections as $section)

                                    <option   value="{{ $section['id'] }}" @if(!empty($category['section_id']) && $category['section_id']==$section['id']) selected @endif>{{ $section['name'] }}</option>
                                    @endforeach

                                </select>
                                <span class="text-danger">
                                    @error('section_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="appendCategoriesLevel">
                                @include('admin.categories.append_categories_level')
                            </div>

                            <div class="form-group">
                                <label for="category_discount">Category Discount</label>
                                <input type="text" class="form-control" name="category_discount" id="category_discount"
                                    placeholder="Enter category Name" @if(!empty($category['category_discount'])) value="{{ $category['category_discount']}}" @else value="{{ old('category_discount') }}" @endif >
                                <span class="text-danger">
                                    @error('category_discount')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="description">Category Discription</label>
                                <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                <span class="text-danger">
                                    @error('category_discount')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="url">Category URL</label>
                                <input type="text" class="form-control" name="url" id="url"
                                    placeholder="Enter Category URL" @if(!empty($category['url'])) value="{{ $category['url']}}" @else value="{{ old('url') }}" @endif >
                                <span class="text-danger">
                                    @error('url')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">Category Meta title</label>
                                <input type="text" class="form-control" name="meta_title" id="meta_title"
                                    placeholder="Enter Category Meta title" @if(!empty($category['meta_title'])) value="{{ $category['meta_title']}}" @else value="{{ old('meta_title') }}" @endif >
                                <span class="text-danger">
                                    @error('meta_title')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="meta_description">Category Meta Description</label>
                                <input type="text" class="form-control" name="meta_description" id="meta_description"
                                    placeholder="Enter Category Meta Description" @if(!empty($category['meta_description'])) value="{{ $category['meta_description']}}" @else value="{{ old('meta_description') }}" @endif >
                                <span class="text-danger">
                                    @error('meta_description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Category Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"
                                    placeholder="Enter Category Keywords" @if(!empty($category['meta_keywords'])) value="{{ $category['meta_keywords']}}" @else value="{{ old('meta_keywords') }}" @endif >
                                <span class="text-danger">
                                    @error('meta_keywords')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="category_image">Category Image</label>
                                <input type="file" class="form-control" name="category_image" id="category_image"
                                    placeholder="Enter Admin Image" required>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        @include('admin.layout.footer')
        <!-- partial -->
    </div>
@endsection



