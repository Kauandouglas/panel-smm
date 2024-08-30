@extends('dashboard.templates.master')
@section('title', 'Usuários')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Usuários</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="search mb-4">
                                    <form action="" class="d-flex justify-content-end">
                                        <input type="search" name="search" placeholder="Pesquisar" class="form-control"
                                               style="width: 250px;" value="{{ request()->search }}">
                                        <button class="btn btn-primary ml-1"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>

                                <div class="mb-3">
                                    <form action="{{ route('dashboard.users.export') }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary ml-1">
                                            <i class="fa fa-arrow-up-from-bracket"></i>
                                            Exportar usuário
                                        </button>
                                    </form>
                                </div>

                                <div class="">
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuário</th>
                                            <th>Saldo</th>
                                            <th>Gasto</th>
                                            <th>Email</th>
                                            <th>Telefone</th>
                                            <th>Ultimo login</th>
                                            <th>Data</th>
                                            <th>Modificações</th>
                                            <th>Opcões</th>
                                        </tr>
                                        @foreach($users as $user)
                                            <tr style="{{ (!$user->status ? 'color: #cecece;' : '') }}">
                                                <td data-label="ID">{{ $user->id }}</td>
                                                <td data-label="Usuário">{{ $user->name }}</td>
                                                <td data-label="Saldo">R$ {{ $user->convert_balance }}</td>
                                                <td data-label="Gasto">R$ {{ $user->orders_sum_price ?? '0.00' }}</td>
                                                <td data-label="Email">{{ $user->email }}</td>
                                                <td data-label="Telefone">{{ $user->phone }}</td>
                                                <td data-label="Ultimo login">{{ $user->convert_date_login }}</td>
                                                <td data-label="Data">{{ $user->convert_date }}</td>
                                                <td data-label="Modificações">
                                                    <a href="{{ route('dashboard.userServicePrices.index', ['user' => $user]) }}">
                                                        <button class="btn btn-outline-primary btn-sm">
                                                            Total
                                                            <span
                                                                class="badge badge-primary">{{ $user->user_service_prices_count }}</span>
                                                        </button>
                                                    </a>
                                                </td>
                                                <td data-label="Opcões">
                                                    <div class="dropdown d-inline mr-2">
                                                        <button class="btn btn-outline-primary dropdown-toggle"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                            Opção
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"
                                                               href="{{ route('dashboard.users.edit', ['user' => $user]) }}">
                                                                Editar
                                                            </a>
                                                            <form
                                                                action="{{ route('dashboard.users.status', ['user' => $user]) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="dropdown-item btn-sm" type="submit"
                                                                        style="padding-left: 20px"
                                                                        href="#">{{ ($user->status ? 'Bloquear' : 'Desbloquear') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{ $users->appends(['search' => request()->search])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
