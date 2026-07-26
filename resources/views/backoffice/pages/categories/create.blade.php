@extends('backoffice.layouts.admin')

@section('title', 'Nouvelle Catégorie | CodeSommet Admin')
@section('page_title', 'Nouvelle Catégorie')

@section('content')
<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    @include('backoffice.pages.categories._form')
</form>
@endsection
