@extends('layout.app')
@section('head')
  <title>Cursos | {{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{ asset('assets/css/dashboard/course.css') }}">
  @php  $sidebarActive = 'course' @endphp
@endsection
@section('content')
  <div class="container">
    <h1>Cursos</h1>
    @include('course.partials.nav',['active' => 'index'])

    {{ var_dump(auth()->user()->courses->toArray()) }}
  </div>
@endsection