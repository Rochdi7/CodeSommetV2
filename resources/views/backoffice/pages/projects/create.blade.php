@extends('backoffice.layouts.admin')

@section('title', 'Nouveau Projet | CodeSommet Admin')
@section('page_title', 'Nouveau Projet')

@section('content')
<form method="POST" action="{{ route('admin.projects.store') }}">
    @csrf
    @include('backoffice.pages.projects._form')
</form>
@endsection