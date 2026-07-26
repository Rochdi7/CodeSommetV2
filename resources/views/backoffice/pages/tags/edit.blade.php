@extends('backoffice.layouts.admin')

@section('title', 'Modifier le Tag | CodeSommet Admin')
@section('page_title', 'Modifier le Tag')

@section('content')
<form method="POST" action="{{ route('admin.tags.update', $tag) }}">
    @csrf
    @method('PUT')
    @include('backoffice.pages.tags._form')
</form>
@endsection
