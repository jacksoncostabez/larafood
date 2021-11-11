@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('products.index') }}" class="">Produtos</a> ({{ auth()->user()->tenant->name }}) </li>
    </ol>

    <h1>Produtos <a href="{{ route('products.create') }}" class="btn btn-dark">ADD <i class="fas fa-plus"></i></a></h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('products.search') }}" method="post" class="form form-inline">
                @csrf
                <input type="text" name="filter" placeholder="Filtrar" class="form-control" value="{{ $filters['filter'] ?? '' }}">
                <button type="submit" class="btn btn-dark">PESQUISAR</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Título</th>
                        <th>Preço</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <img src="{{ url("storage/{$product->image}") }}" alt="{{$product->title}}" style="max-width:80px;">
                            </td>
                            <td>{{ $product->title }}</td>
                            <td>R$ {{ number_format($product->price, 2, ',', '.')}}</td>
                            <td style="width: 10px;">
                                <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info">EDIT</a>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning">VER</a>
                                    <a href="{{ route('products.categories', $product->id) }}" class="btn btn-warning"><i class="fas fa-layer-group" title="Categorias"></i></a>
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
                {!! $products->appends($filters)->links() !!}
            @else
                {!! $products->links() !!}
            @endif
            
        </div>
    </div>
@stop
