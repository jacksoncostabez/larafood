@extends('adminlte::page')

@section('title', "Detalhes da Empresa {$tenant->name}")

@section('content_header')
    <h1>Detalhes da Empresa <b>{{ $tenant->name }}</b></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                <li>
                    <img src="{{ url("storage/{$tenant->logo}") }}" alt="{{$tenant->name}}" style="max-width:80px;">
                </li>
                <li>
                    <strong>Nome: </strong> {{ $tenant->name }}
                </li>
                <li>
                    <strong>CNPJ: </strong> {{ $tenant->cnpj }}
                </li>
                <li>
                    <strong>E-mail: </strong> {{ $tenant->email }}
                </li>
                <li>
                    <strong>Ativo: </strong> {{ $tenant->active == 'Y' ? 'SIM' : 'NÃO' }}
                </li>
            </ul>

            <hr>
            <h3>Assinatura</h3>
            <ul>
                <li>
                    <strong>Plano: </strong> {{ $tenant->plan->name }}
                </li>
                <li>
                    <strong>Data assinatura: </strong> {{ $tenant->subscription }}
                </li>
                <li>
                    <strong>Data Expira: </strong> {{ $tenant->expires_at }}
                </li>
                <li>
                    <strong>Identificador: </strong> {{ $tenant->subscription_id }}
                </li>
                <li>
                    <strong>Ativo? </strong> {{ $tenant->active ? 'SIM' : 'NÃO' }}
                </li>
                <li>
                    <strong>Cancelou? </strong> {{ $tenant->subscription_suspended ? 'SIM' : 'NÃO' }}
                </li>
            </ul>

            @include('admin.includes.alerts')

            <form action="{{ route('tenants.destroy', $tenant->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> DELETAR EMPRESA</button>
            </form>
        </div>
    </div>
@endsection