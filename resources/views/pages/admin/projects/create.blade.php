@extends('layouts.admin')

@section('title', 'Nouveau Projet | CodeSommet Admin')
@section('page_title', 'Nouveau Projet')

@section('content')
<form method="POST" action="{{ route('admin.projects.store') }}">
    @csrf
    @include('pages.admin.projects._form')
</form>
@endsection