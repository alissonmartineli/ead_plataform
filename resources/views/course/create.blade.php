@extends('layout.app')
@section('head')
  <title>Novo Curso | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/content-matters.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/course.css') }}">
  @php  $sidebarActive = 'course' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Novo Curso</h1>
    @include('course.partials.nav',['active' => 'create'])
    <form
      method="POST"
      enctype="multipart/form-data"
      action="{{ route('course.store') }}"
    >
      {{ csrf_field() }}
      <div class="container-grid">
        <div class="form-custom">
          <div class="form-group">
            <label for="course-title">Título</label>
            <input
              type="text"
              name="title"
              id="course-title"
              placeholder="Título do Curso..."
              required
            />
          </div>
          <div class="form-group">
            <label for="course-description">Descrição</label>
            <textarea
              name="description"
              id="course-description"
              placeholder="Descrição do Curso..."
              rows="15"
              required
            ></textarea>
          </div>
        </div>
        <div>
          <label class="form-group form-control" style="
            margin-top: -.2rem;
            display: block;
          ">
            <span style="
              color: #99a;
              padding-bottom: .2rem;
              font-size: .7rem;
            ">Imagem de Capa</span>
            <img
              src="{{ asset('assets/images/no-image.png') }}"
              class="image-mirror" alt="Imagem da Categoria"
              style="width: 100%; height: 24rem; object-fit: cover;"
            />
            <input
              type="file"
              accept="image/*"
              name="wallpaper"
              id="course-wallpaper"
              onchange="handleMirrorFileImg(event,$(this).prev())"
              style="display: none;"
              required
            />
          </label>
        </div>
      </div>
      <strong style="
        margin: 1.2rem 0;
        display: block;
        font-size: 1.2rem;
      ">Selecione a Categoria/Matéria do Curso:</strong>
      <div class="content-matters">
        @if($categoryOuthers)
          <?php $category_default = $categoryOuthers; ?>
          <div
            class="card-matter {{ $category_default->id == $categoryOuthers->id ? 'active':''}}"
            onclick="handleSelectCategory($categoryOuthers->id, '{{ $categoryOuthers->title }}', $(this))"
          >
            <strong style="font-size: 1rem;">{{$categoryOuthers->title}}</strong>
            <div class="matter">
              <img src="{{$categoryOuthers->wallpaper}}" alt="{{$categoryOuthers->title}}" style="
                max-width: 12rem;
                max-height: 20rem;
                object-fit: cover;
              "/>
            </div>
            <small class="paragraph">{{ $categoryOuthers->description }}</small>
          </div>
        @endif
        @foreach($categories as $category)
          <?php if(!isset($category_default)) $category_default = $category; ?>
          <div 
            class="card-matter {{ $category_default->id == $category->id ? 'active':''}}"
            onclick="handleSelectCategory({{ $category->id }}, '{{ $category->title }}', $(this))"
          >
            <strong style="font-size: 1rem;">{{$category->title}}</strong>
            <div class="matter">
              <img src="{{$category->wallpaper}}" alt="{{$category->title}}" style="
                max-width: 12rem;
                max-height: 20rem;
                object-fit: cover;
              "/>
            </div>
            <small class="paragraph">{{ $category->description }}</small>
          </div>
        @endforeach
        <input
          type="hidden"
          name="category_id"
          id="course-category-id"
          value="{{ $category_default->id }}"
          required
        />
      </div>
      <strong style="
        margin: 1.2rem 0 2rem;
        display: block;
        font-size: 1rem;
      ">
        Categoria/Matéria Selecionada:
        <span id="selected-category" style="color: #667;">{{ $category_default->title }}</span>
      </strong>
      <button
        type="submit"
        class="btn btn-primary"
        style="margin: .6rem auto; min-width: 12rem;"
      >Cadastrar</button>
    </form>
  </div>
@endsection
@section('script')
  <script>
    function handleSelectCategory(id, title, target){
      $('#course-category-id').val(id);
      $('#selected-category').html(title);
      $('.card-matter').removeClass('active');
      target.addClass('active');
    }
    function handleMirrorFileImg(event, targetImage){
      let files = event.target.files;
      let src = '';
      if(files){
        for(let index = 0; index < files.length; index++){
          var file = new FileReader();
          file.onload = function(e) {
            src = e.target.result;
            targetImage.attr('src', src ?? image_default);
          };       
          file.readAsDataURL(files[index]);
        }
      }
    }
  </script>
@endsection