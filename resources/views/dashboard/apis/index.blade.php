@extends('dashboard.templates.master')
@section('title', 'Provedores de Api')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Provedores de Api</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#apiModal">
                            Cadastrar Api
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
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>URL</th>
                                            <th>Moeda</th>
                                            <th>Saldo</th>
                                            <th>Opção</th>
                                        </tr>
                                        @foreach($apis as $api)
                                            <tr>
                                                <td>{{ $api->id }}</td>
                                                <td>{{ $api->name }}</td>
                                                <td>{{ $api->url }}</td>
                                                <td>{{ $api->coin }}</td>
                                                <td>{{ $api->balance }}</td>
                                                <td>
                                                    <div class="dropdown d-inline mr-2">
                                                        <button class="btn btn-outline-primary dropdown-toggle"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                            Opção
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#"
                                                               data-action="{{ route('dashboard.apis.update', ['api' => $api]) }}"
                                                               data-name="{{ $api->name }}" data-url="{{ $api->url }}"
                                                               data-token="{{ $api->token }}" data-toggle="modal"
                                                               data-target="#editModal">Editar</a>
                                                            <a class="dropdown-item" href="#"
                                                               data-action="{{ route('dashboard.apis.destroy', ['api' => $api]) }}"
                                                               data-toggle="modal" data-target="#deleteModal">Apagar</a>
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
                                {{ $apis->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletar Api</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Você realmente deseja deletar essa api?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-danger">Deletar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="apiModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastrar Api</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('dashboard.apis.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-globe-africa"></i>
                                    </div>
                                </div>
                                <input type="url" name="url" id="url" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="token">Token</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </div>
                                <input type="text" name="token" id="token" class="form-control">
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

    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Api</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-globe-africa"></i>
                                    </div>
                                </div>
                                <input type="url" name="url" id="url" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="token">Token</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-key"></i>
                                    </div>
                                </div>
                                <input type="text" name="token" id="token" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var action = button.data('action') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('form').attr('action', action)
        })

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var action = button.data('action') // Extract info from data-* attributes
            var name = button.data('name')
            var url = button.data('url')
            var token = button.data('token')

            $(this).find('#name').val(name);
            $(this).find('#url').val(url);
            $(this).find('#token').val(token);

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('form').attr('action', action)
        })
    </script>
@endpush
