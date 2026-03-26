@extends('layouts.admin')

@section('title', 'Nouvel Article | CodeSommet Admin')
@section('page_title', 'Nouvel Article de Blog')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blog.index') }}" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
        Retour aux articles
    </a>
</div>

<form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
    @csrf
    @include('pages.admin.blog._form')
</form>
@endsection
