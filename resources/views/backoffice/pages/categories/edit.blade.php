@extends('backoffice.layouts.admin')

@section('title', 'Modifier la Catégorie | CodeSommet Admin')
@section('page_title', 'Modifier la Catégorie')

@section('content')
<form method="POST" action="{{ route('admin.categories.update', $category) }}">
    @csrf
    @method('PUT')
    @include('backoffice.pages.categories._form')
</form>
@endsection
