@extends('backoffice.layouts.admin')

@section('title', 'Nouveau Tag | CodeSommet Admin')
@section('page_title', 'Nouveau Tag')

@section('content')
<form method="POST" action="{{ route('admin.tags.store') }}">
    @csrf
    @include('backoffice.pages.tags._form')
</form>
@endsection
