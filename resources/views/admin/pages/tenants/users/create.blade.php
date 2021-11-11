@extends('adminlte::page')

@section('title', 'Cadastrar Novo Usuário')

@section('content_header')
    <h1>Cadastrar Novo Usuário Para <strong>{{ $tenant->name }}</strong></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tenants.users.store', $tenant->id) }}" class="form" method="POST">
                @csrf
                @include('admin.pages.tenants.users._partials.form')
            </form>
        </div>
    </div>
@endsection