@extends('adminlte::page')

@section('title', 'Empresas')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tenants.index') }}" class="">Empresas</a> ({{ auth()->user()->tenant->name }}) </li>
    </ol>

    <h1>Empresas</h1>
    {{-- <h1>Empresas <a href="{{ route('tenants.create') }}" class="btn btn-dark">ADD <i class="fas fa-plus"></i></a></h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('tenants.search') }}" method="post" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Filtrar" class="form-control" value="{{ $filters['filter'] ?? '' }}">
                <button type="submit" class="btn btn-dark">PESQUISAR</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Plano</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $tenant)
                        <tr>
                            <td>
                                <img src="{{ url("storage/{$tenant->logo}") }}" alt="{{$tenant->name}}" style="max-width:80px;">
                            </td>
                            <td>{{ $tenant->name }}</td>
                            <td>{{ $tenant->cnpj }}</td>
                            <td>{{ $tenant->plan->name }}</td>
                            <td style="width: 10px;">
                                <form action="{{ route('tenants.destroy', $tenant->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-info">EDIT</a>
                                    <a href="{{ route('tenants.show', $tenant->id) }}" class="btn btn-warning">VER</a>
                                    <a href="{{ route('tenants.users', $tenant->id) }}" class="btn btn-warning">USERS</a>
                                    <button type="submit" class="btn btn-danger" title="Deletar">DEL</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
                {!! $tenants->appends($filters)->links() !!}
            @else
                {!! $tenants->links() !!}
            @endif
            
        </div>
    </div>
@stop
