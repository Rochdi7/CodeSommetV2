@extends('backoffice.layouts.admin')

@section('title', 'Nouveau Paiement | CodeSommet Admin')
@section('page_title', 'Nouveau Paiement')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.payments.store') }}">
        @csrf
        @include('backoffice.pages.payments._form')
    </form>
</div>
@endsection