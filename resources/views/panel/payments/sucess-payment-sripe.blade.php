@extends('panel.templates.master')
@section('title', 'Pagamento Sucesso')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pagamento Sucesso</h1>
            </div>

            <div class="section-body">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body" id="addFunds">
                            <div class="tab-content" id="paymentTabContent">
                                <div class="tab-pane fade show active" id="pix" role="tabpanel"
                                     aria-labelledby="pix-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="for-group text-center">
                                                <img src="{{ asset('panel/img/success-icon-19.png') }}"
                                                     style="max-width: 150px;" alt="pix">
                                                <h4 class="p-t-10 mt-3">Seu pagamento foi aprovado com sucesso!</h4>
                                                <a href="{{ route('panel.orders.create') }}">
                                                    <button class="btn btn-outline-primary btn-lg mt-3">Gerar
                                                        Pedido
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
