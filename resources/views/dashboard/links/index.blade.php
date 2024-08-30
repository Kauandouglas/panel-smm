@extends('dashboard.templates.master')
@section('title', 'Links')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Links</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Total de Links</h4>
                            </div>
                            <div class="card-body">
                                <div class="section-body category">
                                    <button class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#linkModal">
                                        Cadastrar Link
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            <th>Link</th>
                                            <th>Clicks</th>
                                            <th>Data</th>
                                        </tr>
                                        @foreach($links as $link)
                                            <tr>
                                                <td>
                                                    <a target="_blank" href="{{ route('web.ref', ['code' => $link->slug]) }}">
                                                        {{ route('web.ref', ['code' => $link->slug]) }}
                                                    </a>
                                                </td>
                                                <td>{{ $link->click }}</td>
                                                <td>{{ $link->created_at }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{ $links->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="linkModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.links.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-link"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" placeholder="Digite o nome" id="name"
                                       name="name">
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
