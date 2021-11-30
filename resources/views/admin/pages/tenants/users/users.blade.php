@extends('adminlte::page')

@section('title', "Usuários da Empresa {$tenant->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tenants.index') }}">Empresas</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tenants.users', $tenant->id) }}" class="">Usuários</a></li>
    </ol>

    <h1>Usuários da Empresa <strong>{{ $tenant->name }}</strong></h1>
    <a href="{{ route('tenants.users.create', $tenant->id) }}" class="btn btn-success" title="Criar">CRIAR NOVO USUÁRIO</a>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Usuários</th>
                        <th>E-mail</th>
                        <th width="50">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td style="width: 150px;">
                                <form action="{{ route('tenants.users.destroy', [$user->id, $user->tenant->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('tenants.users.edit', [$user->id, $user->tenant->id]) }}" class="btn btn-info" title="Editar">EDIT</a>
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
                {!! $users->appends($filters)->links() !!}
            @else
                {!! $users->links() !!}
            @endif
        </div>
    </div>
@stop
