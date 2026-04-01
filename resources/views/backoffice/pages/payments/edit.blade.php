@extends('backoffice.layouts.admin')

@section('title', 'Modifier Paiement | CodeSommet Admin')
@section('page_title', 'Modifier le Paiement')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
        @csrf
        @method('PUT')
        @include('backoffice.pages.payments._form')
    </form>
</div>
@endsection