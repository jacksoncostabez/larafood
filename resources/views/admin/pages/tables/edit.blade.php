@extends('adminlte::page')

@section('title', "Editar Mensa {$table->identify}")

@section('content_header')
    <h1>Editar Mensa</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('tables.update', $table->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')

                @include('admin.pages.tables._partials.form')
            </form>
        </div>
    </div>
@endsection