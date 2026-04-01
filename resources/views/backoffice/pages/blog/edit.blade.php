@extends('backoffice.layouts.admin')

@section('title', 'Modifier Article | CodeSommet Admin')
@section('page_title', 'Modifier l\'Article')

@section('content')
<div class="flex items-center justify-between mb-6">
    <a href="{{ route('admin.blog.index') }}" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
        Retour aux articles
    </a>
    @if($post->status === 'published')
    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="admin-btn admin-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" x2="21" y1="14" y2="3"></line></svg>
        Voir l'article
    </a>
    @endif
</div>

<form method="POST" action="{{ route('admin.blog.update', $post) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('backoffice.pages.blog._form')
</form>
@endsection
