@extends('adminlte::page')

@section('title', "Usuários disponíveis para o cargo {$role->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Cargos</a></li>
        <li class="breadcrumb-item"><a href="{{ route('roles.users', $role->id) }}" class="">Usuários</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('roles.users.available', $role->id) }}">Disponíveis</a></li>
    </ol>

    <h1>Usuários disponíveis para o cargo <strong>{{ $role->name }}</strong></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('roles.users.available', $role->id) }}" method="post" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Nome" class="form-control" value="{{ $filters['filter'] ?? '' }}">
                <button type="submit" class="btn btn-dark">PESQUISAR</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th>Perfis</th>
                        <th>Empresa</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="{{ route('roles.users.attach', $role->id) }}" method="post">
                        @csrf

                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <input type="checkbox" name="users[]" value="{{ $user->id }}">
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->tenant->name }}
                                </td>
                            </tr>
                        @endforeach
                        
                        <tr>
                            <td colspan="500">
                                @include('admin.includes.alerts')
                                <button type="submit" class="btn btn-success">Vincular</button>
                            </td>
                        </tr>
                    </form>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $users->appends($filters)->links() !!}
            @else
                {!! $users->links() !!}
            @endif
            
        </div>
    </div>
@stop
