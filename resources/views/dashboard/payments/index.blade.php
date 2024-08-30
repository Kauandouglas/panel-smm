@extends('dashboard.templates.master')
@section('title', 'Pagamentos')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pagamentos</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addBalanceModal">
                                    Adicionar Saldo
                                </button>

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
                                            <th>Usuário</th>
                                            <th>Preco</th>
                                            <th>Memo</th>
                                            <th>Status</th>
                                            <th>Data</th>
                                        </tr>
                                        @foreach($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->id }}</td>
                                                <td>{{ $payment->user->email }}</td>
                                                <td>R$ {{ $payment->price }}</td>
                                                <td>{{ $payment->memo }}</td>
                                                <td>
                                                    <button class="btn btn-sm
                                                    {{ ($payment->status ? 'btn-success' : 'btn-warning') }}">
                                                        {{ $payment->status_string }}
                                                    </button>
                                                </td>
                                                <td>{{ $payment->convert_date }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{ $payments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Add Balance --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="addBalanceModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Saldo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="messageError" class="alert alert-danger mt-4 d-none"></div>

                    <form action="{{ route('dashboard.payments.store') }}" method="POST" id="formAddBalance">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="balance">Saldo</label>
                            <div class="input-group">
                                <input type="text" name="balance" id="balance" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="memo">Memo</label>
                            <div class="input-group">
                                <input type="text" name="memo" id="memo" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="spinner-border spinner-border-sm mr-1 d-none"
                                      role="status" aria-hidden="true"></span>
                                Adicionar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
