<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ env('APP_NAME') }}</title>

  {{-- css libraies --}}
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="ckeditor/plugins/codesnippet/lib/highlight/styles/default.css" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col bg-[#fafafa]">
  
  {{-- header --}}
  <header class="py-3 shadow-md">
    <div class="w-4/5 mx-auto flex flex-row justify-between items-center">
      <a href="{{ route('index') }}" class="text-2xl capitalize font-bold">{{ env('APP_NAME') }}</a>
      <ul class="flex items-center gap-5">
        {{-- <li><a href="{{ route('index') }}" class="text-sm font-medium capitalize">beranda</a></li>
        <li><a href="#" class="text-sm font-medium capitalize">artikel</a></li> --}}
        <li class="flex gap-2">
          @if (!auth()->user())
            <a href="{{ route('auth.login.view') }}" class="text-sm font-medium capitalize bg-gray-200 px-4 py-2 rounded-md">login</a>
            <a href="{{ route('auth.register.view') }}" class="text-sm font-medium capitalize text-white bg-gray-400 px-4 py-2 rounded-md">register</a>
          @else
            <a href="{{ route('article.create.view') }}" class="text-sm font-medium capitalize bg-gray-200 px-4 py-2 rounded-md">write</a>
            <a href="{{ route('auth.logout.action') }}" class="text-sm font-medium capitalize text-white bg-gray-400 px-4 py-2 rounded-md">logout</a>
          @endif
        </li>
      </ul>
    </div>
  </header>
  {{-- header --}}

  {{-- content --}}
  <main id="root" class="flex-1">
    @yield('content')
  </main>
  {{-- content --}}

  {{-- footer --}}
  <footer class="py-5 border-t bg-white border-gray-300">
    <div class="w-4/5 mx-auto">
      <div class="text-xs font-semibold text-gray-500">© {{ date('Y') . ' ' . env('APP_NAME') }}. All rights reserved</div>
    </div>
  </footer>
  {{-- footer --}}

  {{-- js libraies --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha512-fzff82+8pzHnwA1mQ0dzz9/E0B+ZRizq08yZfya66INZBz86qKTCt9MLU0NCNIgaMJCgeyhujhasnFUsYMsi0Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{ asset('assets/js/vanilla-tilt.min.js') }}"></script>
  <script src="/ckeditor/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://unpkg.com/vue@next"></script>

  {{-- default script --}}
  @stack('script')
</body>
</html>