@extends('layout.main')

@section('content')
  {{-- info --}}
  <section class="mt-10">
    <div class="w-4/5 mx-auto">
      <div class="text-xl lg:text-3xl font-semibold text-center">
        Baca dan Pelajari Ribuan Artikel dan <br> Tutorial Coding Secara Gratis
      </div>
      <div class="text-sm lg:text-lg font-medium text-gray-500 text-center mt-5">
        Pengetahuan adalah senjata para developer profesional <br> dalam membangun masa depan
      </div>
      <div class="flex justify-center mt-5">
        <form @submit.prevent="search" action="" method="post" autocomplete="off" class="w-full lg:w-1/2 flex justify-between border rounded-md">
          <input v-model="keyword" type="text" name="keyword" id="keyword"  class="w-full rounded-tl-md rounded-bl-md focus:outline-none focus:ring-2 focus:ring-gray-400 px-4 py-2" placeholder="Cari artikel...">
          <button type="submit" class="px-4"><i class="fas fa-search"></i></button>
        </form>
      </div>
      <div class="flex justify-center mt-10">
        <ul class="category-list w-full lg:w-1/2 flex flex-col lg:flex-row justify-between space-y-2 lg:space-y-0">
          <li><a href="#" v-on:click.prevent="filter" data-slug="semua" data-category-id="semua" class="inline-block w-full lg:w-auto text-center text-sm uppercase font-semibold border-2 rounded-md transition-all duration-300 bg-gray-200 hover:bg-gray-200 px-4 py-2">semua</a></li>
          @foreach ($categories as $category)
            <li><a href="#" v-on:click.prevent="filter" data-slug="{{ $category->slug }}" data-category-id="{{ $category->id }}" class="inline-block w-full lg:w-auto text-center text-sm uppercase font-semibold border-2 rounded-md transition-all duration-300 hover:bg-gray-200 px-4 py-2">{{ $category->title }}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>
  {{-- info --}}

  {{-- content article --}}
  <section class="my-10">
    <div class="w-4/5 mx-auto">
      <div class="grid lg:grid-cols-3 gap-6 justify-center mb-10">
        <a v-for="article in articles" v-bind:href="'/' + article.slug" class="cursor-pointer" data-tilt data-tilt-max="5">
          <img v-bind:src="'/storage/' + article.thumbnail" v-bind:alt="article.slug" class="w-full h-[12rem] object-cover rounded-lg">
          <div class="text-sm lg:text-base font-semibold mt-2">@{{ article.title }}</div>
          <div class="flex justify-between text-xs text-gray-500 font-semibold mt-2">
            <span class="capitalize font-bold bg-gray-200 px-2 py-1 rounded">@{{ article.category.title }}</span> @{{ article.created_at }}
          </div>
        </a>
      </div>
      <div class="flex justify-center">
        <button v-on:click="loadMore" type="button" class="text-sm capitalize font-semibold border-2 rounded-md transition-all duration-300 hover:bg-gray-200 px-4 py-2">tampilkan lebih banyak</button>
      </div>
    </div>
  </section>
  {{-- content article --}}
@endsection

@push('script')
  <script>
    const app = {
      data() {
        return {
          articles: [],
          keyword: '',
          categoryId: 'semua',
          take: 6,
        }
      },
      methods: {
        async search(){
          if(this.keyword != ''){
            const response = await fetch(`/api/v1/articles?q=${this.keyword}`).then(res => res.json());
            this.articles = response.map(article => {
              return {...article, created_at: moment(article.created_at).fromNow()}
            });
          } else {
            const response = await fetch('/api/v1/articles').then(res => res.json());
            this.articles = response.map(article => {
              return {...article, created_at: moment(article.created_at).fromNow()}
            });
          }
        },
        async filter(e){
          const categorySlug = e.target.getAttribute('data-slug');
          const categoryId = e.target.getAttribute('data-category-id');
          const categoryList = document.querySelectorAll('.category-list li');

          const response = await fetch(`/api/v1/articles?category=${categoryId}`).then(res => res.json());
          
          categoryList.forEach((item)=>{
            const CategoryItem = item.querySelector('a');
            const itemSlug = CategoryItem.getAttribute('data-slug');
            
            if(itemSlug == categorySlug) {
              CategoryItem.classList.toggle('bg-gray-200');
            } else{
              CategoryItem.classList.remove('bg-gray-200');
            }

          });

          this.articles = response.map(article => {
            return {...article, created_at: moment(article.created_at).fromNow()}
          });
          this.categoryId = categoryId;
        },
        async loadMore(){
          this.take += 3;

          const response = await fetch(`/api/v1/articles?category=${this.categoryId}&take=${this.take}`).then(res => res.json());
          this.articles = response.map(article => {
            return {...article, created_at: moment(article.created_at).fromNow()}
          });
        }
      },
      async mounted(){
        this.$nextTick(async () =>{
          const response = await fetch(`/api/v1/articles?take=${this.take}`).then(res => res.json());
          this.articles = response.map(article => {
            return {...article, created_at: moment(article.created_at).fromNow()}
          });
        });
      },
    };

    Vue.createApp(app).mount('#root');
  </script>
@endpush