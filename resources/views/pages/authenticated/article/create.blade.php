@extends('layout.main')

@section('content')
  {{-- article create form --}}
  <section class="my-10">
    <div class="w-4/5 h-full mx-auto">
      <div class="space-y-5">
        <form action="{{ route('article.create.action') }}" method="POST" enctype="multipart/form-data" autocomplete="off" class="bg-white p-5 rounded-md">
          @csrf
          <div class="mb-3">
            <label for="title" class="block text-sm capitalize font-semibold">title</label>
            <input type="text" id="title" name="title" placeholder="Enter title..." class="w-full px-4 py-2 rounded-md ring-2 ring-gray-300 focus:outline-none focus:ring-gray-400 mt-2">
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
                <option value="{{ $category->id }}">{{ ucwords($category->title) }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="content" class="block text-sm capitalize font-semibold">content</label>
            <textarea id="content" name="content"></textarea>
          </div>
          <div>
            <button type="submit" class="text-sm capitalize font-semibold border-2 rounded-md transition-all duration-300 bg-gray-200 hover:bg-gray-300 px-8 py-2">write</button>
          </div>
        </form>
        <div class="bg-white p-5 rounded-md overflow-x-scroll lg:overflow-auto">
          @if ($articles->isNotEmpty())
            <table class="w-full text-sm table-auto">
              <thead>
                <tr>
                  <th class="capitalize text-left border border-gray-300 p-2">title</th>
                  <th class="capitalize text-left border border-gray-300 p-2">category</th>
                  <th class="capitalize text-left border border-gray-300 p-2">status</th>
                  <th class="capitalize text-left border border-gray-300 p-2">views</th>
                  <th class="capitalize text-left border border-gray-300 p-2">created at</th>
                  <th class="capitalize text-left border border-gray-300 p-2">action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($articles as $article)
                  <tr>
                    <td class="border border-gray-300 p-2">
                      <a href="{{ route('article.show', $article->slug) }}" class="underline hover:no-underline transition-all duration-300">{{ $article->title }}</a>
                    </td>
                    <td class="capitalize font-medium border border-gray-300 p-2">{{ $article->category->title }}</td>
                    <td class="border border-gray-300 p-2">
                      <span class="text-xs capitalize font-medium text-white {{ $article->status == 'draft' ? 'bg-red-500' : 'bg-green-500' }} rounded-md py-1 px-2 mb-2">{{ $article->status }}</span>
                    </td>
                    <td class="border border-gray-300 p-2">{{ $article->view_count }}</td>
                    <td class="border border-gray-300 p-2">{{ $article->created_at->diffForHumans() }}</td>
                    <td class="border border-gray-300 p-2">
                      <a href="{{ route('article.update.view', $article->slug) }}" class="text-xs capitalize font-medium text-white bg-green-500 hover:bg-green-600 transition-all duration-300 rounded-md py-1 px-2 mb-2">update</a>
                      <a href="{{ route('article.delete.action', $article->slug) }}" class="text-xs capitalize font-medium text-white bg-red-500 hover:bg-red-600 transition-all duration-300 rounded-md py-1 px-2 mb-2">delete</a>
                      @if (auth()->user()->is_admin && $article->status == 'draft')
                        <a href="{{ route('article.publish.action', $article->slug) }}" class="text-xs capitalize font-medium text-white bg-blue-500 hover:bg-blue-600 transition-all duration-300 rounded-md py-1 px-2 mb-2">publish</a>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <div class="mt-4">
              {{ $articles->links() }}
            </div>
          @else
            <div class="text-center text-sm font-semibold capitalize">lets write someting...</div>
          @endif
        </div>
        @if (auth()->user()->is_admin)
          <div class="bg-white p-5 rounded-md">
            <table class="w-full text-sm table-auto">
              <thead>
                <tr>
                  <th class="capitalize text-left border border-gray-300 p-2">username</th>
                  <th class="capitalize text-left border border-gray-300 p-2">category</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td class="border border-gray-300 p-2">{{ $user->username }}</td>
                    <td class="capitalize font-medium border border-gray-300 p-2">{{ $user->is_admin ? 'admin' : 'writter' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>
  </section>
  {{-- article create form --}}
@endsection

@push('script')
<script>
  CKEDITOR.replace('content');
</script>
@endpush
