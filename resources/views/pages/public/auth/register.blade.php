@extends('layout.main')

@section('content')
<section class="my-10">
  <div class="lg:w-4/5 h-full mx-auto flex flex-col items-center">
    <div class="text-lg capitalize font-semibold mb-3">register your account</div>
    <form action="{{ route('auth.register.action') }}" method="POST" enctype="multipart/form-data" autocomplete="off" class="w-4/5 lg:w-1/2 bg-white p-5 rounded-md">
      @csrf
      <div class="mb-3">
        <label for="username" class="block text-sm capitalize font-semibold">username</label>
        <input type="text" id="username" name="username" placeholder="Enter username..." class="w-full px-4 py-2 rounded-md ring-2 ring-gray-300 focus:outline-none focus:ring-gray-400 mt-2">
        @error('username')<div class="text-xs lowercase text-red-500 mt-2">{{$message}}</div>@enderror
      </div>
      <div class="mb-3">
        <label for="password" class="block text-sm capitalize font-semibold">password</label>
        <input type="password" id="password" name="password" placeholder="Enter password..." class="w-full px-4 py-2 rounded-md ring-2 ring-gray-300 focus:outline-none focus:ring-gray-400 mt-2">
        @error('password')<div class="text-xs lowercase text-red-500 mt-2">{{$message}}</div>@enderror
      </div>
      <div class="mb-6">
        <label for="avatar" class="block text-sm capitalize font-semibold">choose your avatar</label>
        <input type="file" id="avatar" name="avatar" class="w-full text-sm font-semibold border-2 border-gray-300 rounded-md file:bg-gray-300 file:border-none file:text-gray-800 file:text-sm file:font-semibold file:px-4 file:py-2 mt-2">
      </div>
      <div>
        <button type="submit" class="text-sm capitalize font-semibold border-2 rounded-md transition-all duration-300 bg-gray-200 hover:bg-gray-300 px-8 py-2">submit</button>
      </div>
    </form>
  </div>
</section>
@endsection