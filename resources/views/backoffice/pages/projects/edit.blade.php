@extends('backoffice.layouts.admin')

@section('title', 'Modifier ' . $project->name . ' | CodeSommet Admin')
@section('page_title', 'Modifier le Projet')

@section('content')
<form method="POST" action="{{ route('admin.projects.update', $project) }}">
    @csrf
    @method('PUT')
    @include('backoffice.pages.projects._form')
</form>
@endsection