<div class="form-group">
    <label for="parent_id">Select Category Level</label>
    <select name="parent_id" id="parent_id" class="form-control"  style="color: #000;">
        <option value="0" @if(isset($category['parent_id']) && $category['parent_id']==0) selected="" @endif>Main Category</option>
        @if(!empty($getCategories))
          @foreach($getCategories as $parentcategory)
            <option value="{{ $parentcategory['id'] }}" @if(isset($category['parent_id']) && $category['parent_id']==$parentcategory['id']) selected="" @endif>{{ $parentcategory['category_name'] }}</option>
            @if(!empty($parentcategory['subCategories']))
              @foreach($parentcategory['subCategories'] as $subCategory)
                <option value="{{ $subCategory['id'] }}" @if(isset($subCategory['parent_id']) && $subCategory['parent_id']==$subCategory['id']) selected="" @endif>&nbsp;&raquo;&nbsp;{{ $subCategory['category_name'] }}</option>
              @endforeach
            @endif
          @endforeach
        @endif
    </select>
    <span class="text-danger">
        @error('parent_id')
            {{ $message }}
        @enderror
    </span>
</div>
