@extends('adminlte::page')

@section('title', 'Perfis')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('profiles.index') }}" class="">Perfis</a></li>
    </ol>

    <h1>Perfis <a href="{{ route('profiles.create') }}" class="btn btn-dark">ADD <i class="fas fa-plus"></i></a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('profiles.search') }}" method="post" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Nome" class="form-control" value="{{ $filters['filter'] ?? '' }}">
                <button type="submit" class="btn btn-dark">PESQUISAR</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th width="280">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profiles as $profile)
                        <tr>
                            <td>
                                {{ $profile->name }}
                            </td>
                            <td style="width: 10px;">
                                {{-- <a href="{{ route('details.plan.index', $plan->url) }}" class="btn btn-primary">Detalhes</a> --}}
                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-info">EDIT</a>
                                    <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-warning">VER</a>
                                    <a href="{{ route('profiles.permissions', $profile->id) }}" class="btn btn-warning"><i class="fas fa-lock" title="Permissões"></i></a>
                                    <a href="{{ route('profiles.plans', $profile->id) }}" class="btn btn-info"><i class="fas fa-list-ul" title="Planos"></i></a>
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
                {!! $profiles->appends($filters)->links() !!}
            @else
                {!! $profiles->links() !!}
            @endif
        </div>
    </div>
@stop
