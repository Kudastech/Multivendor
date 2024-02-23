<div class="form-group">
    <label for="parent_id">Select Category Level</label>
    <select name="parent_id" id="parent_id" class="form-control">
        <option value="0" @if(isset($category['parent_id'] && $category['parent_id']==0)) selected @endif >Main Category</option>
        @if (!empty($getCategories))
            @foreach ($getCategories as $category)
                <option value="{{ $category['id'] }}" @if(isset($category['parent_id'] && $category['parent_id']==0)) selected @endif >{{ $category['category_name'] }}</option>
            @endforeach
        @endif
    </select>
    <span class="text-danger">
        @error('parent_id')
            {{ $message }}
        @enderror
    </span>
</div>
