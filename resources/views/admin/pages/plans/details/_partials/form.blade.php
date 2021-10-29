@include('admin.includes.alerts')

@csrf

<div class="form-group">
    <label>Detalhe:</label>
    <input type="text" name="name" placeholder="Novo Detalhe..." class="form-control" value="{{ $detail->name ?? old('name') }}">
</div>
<div class="form-group">
    <button type="submit" class="btn btn-info">Enviar</button>
</div>