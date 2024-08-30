@extends('dashboard.templates.master')
@section('title', 'Serviços Preço')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Serviços Preço</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#userServicePriceModal">
                            Cadastrar Serviços
                        </button>

                        <div class="card">
                            <div class="card-body">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success">{!! session('success') !!}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            <th>Usuário</th>
                                            <th>Serviço</th>
                                            <th>Preço</th>
                                            <th>Preço Modificado</th>
                                            <th>Opções</th>
                                        </tr>
                                        @foreach($userServicePrices as $userServicePrice)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $userServicePrice->service->id }} -
                                                    {{ $userServicePrice->service->name }}</td>
                                                <td>R$ {{ $userServicePrice->service->price }}</td>
                                                <td>R$ {{ $userServicePrice->price }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('dashboard.userServicePrices.destroy', ['userServicePrice' => $userServicePrice]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">Remover</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="userServicePriceModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar Preços</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="service_id">Servicos</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fab fa-instagram"></i>
                                    </div>
                                </div>
                                <select name="service_id" id="service_id" class="form-control">
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->id }}
                                            - {{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">Preço</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-dollar-sign"></i>
                                    </div>
                                </div>
                                <input type="text" name="price" id="price" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
