@extends('adminlte::page')

@section('title', "Editar Usuário {$user->name}")

@section('content_header')
    <h1>Editar Usuário da Empresa <strong>{{ $tenant->name }}</strong></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tenants.users.update', [$user->id, $user->tenant->id]) }}" class="form" method="POST">
                @csrf
                @method('PUT')

                @include('admin.pages.tenants.users._partials.form')
            </form>
        </div>
    </div>
@endsection