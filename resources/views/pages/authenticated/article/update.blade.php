@extends('layout.main')

@section('content')
  {{-- article update form --}}
  <section class="my-10">
    <div class="w-4/5 h-full mx-auto">
      <div class="space-y-5">
        <form action="{{ route('article.update.action', $article->slug) }}" method="POST" enctype="multipart/form-data" autocomplete="off" class="bg-white p-5 rounded-md">
          @csrf
          @method('put')
          <div class="mb-3">
            <label for="title" class="block text-sm capitalize font-semibold">title</label>
            <input type="text" id="title" name="title" value="{{ $article->title }}" placeholder="Enter title..." class="w-full px-4 py-2 rounded-md ring-2 ring-gray-300 focus:outline-none focus:ring-gray-400 mt-2">
            @error('title')<div class="text-xs lowercase text-red-500 mt-2">{{$message}}</div>@enderror
          </div>
          <div class="mb-6">
            <label for="thumbnail" class="block text-sm capitalize font-semibold">choose your thumbnail</label>
            <input type="file" id="thumbnail" name="thumbnail" class="w-full text-sm font-semibold border-2 border-gray-300 rounded-md file:bg-gray-300 file:border-none file:text-gray-800 file:text-sm file:font-semibold file:px-4 file:py-2 mt-2">
          </div>
          <div class="mb-6">
            <label for="category" class="block text-sm capitalize font-semibold">choose category</label>
            <select id="category" name="category" class="w-full px-4 py-2 rounded-md ring-2 ring-gray-300 focus:outline-none focus:ring-gray-400 appearance-none mt-2">
              @foreach ($categories as $category)
                @if ($category->id == $article->category_id)
                  <option value="{{ $category->id }}" selected>{{ ucwords($category->title) }}</option>
                @else
                  <option value="{{ $category->id }}">{{ ucwords($category->title) }}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="content" class="block text-sm capitalize font-semibold">content</label>
            <textarea id="content" name="content">{{ $article->content }}</textarea>
          </div>
          <div>
            <button type="submit" class="text-sm capitalize font-semibold border-2 rounded-md transition-all duration-300 bg-gray-200 hover:bg-gray-300 px-8 py-2">update</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  {{-- article update form --}}
@endsection

@push('script')
<script>
  CKEDITOR.replace('content');
</script>
@endpush
