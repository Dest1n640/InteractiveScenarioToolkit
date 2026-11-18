@csrf

<p>
    <label>Category<br>
        <select name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </label>
    @error('category_id') <br><span class="error">{{ $message }}</span> @enderror
</p>

<p>
    <label>Title<br><input name="title" size="50" value="{{ old('title', $post->title) }}"></label>
    @error('title') <br><span class="error">{{ $message }}</span> @enderror
</p>

<p>
    <label>Body<br><textarea name="body" rows="6" cols="60">{{ old('body', $post->body) }}</textarea></label>
    @error('body') <br><span class="error">{{ $message }}</span> @enderror
</p>

<p>
    Tags:
    @foreach ($tags as $tag)
        <label><input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, (array) old('tags', $post->tags->modelKeys())))> {{ $tag->name }}</label>
    @endforeach
    @error('tags') <br><span class="error">{{ $message }}</span> @enderror
    @error('tags.*') <br><span class="error">{{ $message }}</span> @enderror
</p>

<p>
    <input type="hidden" name="is_published" value="0">
    <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published))> Published</label>
</p>

<p>
    <label>Published at<br><input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"></label>
    @error('published_at') <br><span class="error">{{ $message }}</span> @enderror
</p>

<button type="submit">Save</button>
