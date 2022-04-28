@extends('layout.main')

@section('content')
{{-- content article --}}
<section class="my-10">
  <div class="w-4/5 mx-auto">
    <div>
      <div class="text-3xl capitalize font-semibold">{{ $article->title }}</div>
      <div class="text-sm font-medium capitalize text-gray-400 mt-2">
        created by <span class="text-gray-800 font-semibold">{{ $article->author->username }}</span>,
        created at <span class="text-gray-800 font-semibold">{{ date_format($article->created_at, 'd M Y') }}</span>,
        viewed as much <i class="fas fa-eye ml-2"></i> <span class="text-gray-800 font-semibold ml-1">{{ $article->view_count }}</span>
      </div>
      <img src="{{ '/storage/' . $article->thumbnail }}" alt="{{ $article->slug }}" class="w-full h-[25rem] object-cover rounded-lg mt-4">
      <div class="mt-4 prose">
        {!! $article->content !!}
      </div>
    </div>
  </div>
</section>
{{-- content article --}}
@endsection