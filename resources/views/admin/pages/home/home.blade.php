@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('users.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalUsers }}</h3>
          
                  <p>Usuários</p>
                </div>
                <div class="icon">
                  <i class="fas fa-users"></i>
                </div>
                {{--<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
              </div>
          </a>
          </div>
        

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('tables.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalTables }}</h3>
          
                  <p>Mesas</p>
                </div>
                <div class="icon">
                  <i class="fas fa-table"></i>
                </div>
            </div>
            </a>
          </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('categories.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalCategories }}</h3>

                  <p>Categorias</p>
                </div>
                <div class="icon">
                  <i class="fas fa-layer-group"></i>
                </div>
              </div>
            </a>
          </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('products.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalProducts }}</h3>

                  <p>Produtos</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hamburger"></i>
                </div>
              </div>
            </a>
          </div>

        @admin() {{-- Vem lá do  AppServiceProvider.php --}}
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('tenants.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalTenants }}</h3>

                  <p>Empresas</p>
                </div>
                <div class="icon">
                  <i class="far fa-building"></i>
                </div>
              </div>
            </a>
          </div>
          @endadmin

        @admin()
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('plans.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalPlans }}</h3>

                  <p>Planos</p>
                </div>
                <div class="icon">
                  <i class="fas fa-list-ul"></i>
                </div>
              </div>
            </a>
          </div>
          @endadmin

        @admin()
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('roles.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalCargos }}</h3>

                  <p>Cargos</p>
                </div>
                <div class="icon">
                  <i class="fas fa-briefcase"></i>
                </div>
              </div>
            </a>
          </div>
          @endadmin

        @admin()
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('profiles.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalProfiles }}</h3>

                  <p>Perfis</p>
                </div>
                <div class="icon">
                  <i class="fas fa-address-book"></i>
                </div>
              </div>
            </a>
          </div>
          @endadmin

        @admin()
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <a href="{{ route('permissions.index') }}">
              <div class="small-box">
                <div class="inner">
                  <h3>{{ $totalPermissions }}</h3>

                  <p>Permissões</p>
                </div>
                <div class="icon">
                  <i class="fas fa-lock"></i>
                </div>
              </div>
            </a>
          </div>
          @endadmin
    </div>
    
@endsection