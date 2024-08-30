@extends('panel.templates.master')
@section('title', 'Adicionar saldo')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Adicionar saldo</h1>
            </div>

            <div class="section-body">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body" id="addFunds">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pix-tab" data-toggle="tab"
                                            data-target="#pix" type="button" role="tab" aria-controls="pix"
                                            aria-selected="true"><i class="fab fa-pix"></i> Pix
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="cart-tab" data-toggle="tab"
                                            data-target="#cart" type="button" role="tab" aria-controls="cart"
                                            aria-selected="false"><i class="fas fa-credit-card"></i> Cartão de crédito
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="paymentTabContent">
                                <div class="tab-pane fade show active" id="pix" role="tabpanel"
                                     aria-labelledby="pix-tab">
                                    <form class="form" id="actionAddFundsForm" action="#" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="for-group text-center">
                                                    <img src="{{ asset('panel/img/pix.png') }}"
                                                         style="max-width: 250px;"
                                                         alt="pix">
                                                    <p class="p-t-10 mt-2">
                                                        <small>Seu saldo será adicionado automaticamente após o
                                                            pagamento!</small>
                                                    </p>
                                                </div>
                                                <div class="alert alert-danger d-none" id="messageError"></div>
                                                <div class="form-group">
                                                    <label for="price">Valor (BRL)</label>
                                                    <input class="form-control square" type="number" id="price"
                                                           name="price" placeholder="1">
                                                </div>
                                                <div class="form-group">
                                                    <label>Nota:</label>
                                                    <ul>
                                                        <li>
                                                            Insira o valor desejado, clique em gerar <b>Efetuar
                                                                Pagamento</b> e
                                                            pague usando o Pix;
                                                        </li>
                                                        <li>O valor é adicionado <b>imediatamente</b> após o pagamento;
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="form-actions">
                                                    <button type="submit"
                                                            class="btn round btn-primary btn-min-width mr-1 mb-1">
                                                        <i class="fas fa-lock m-1"></i>
                                                        EFETUAR PAGAMENTO
                                                        <span class="spinner-border spinner-border-sm ml-1 d-none"
                                                              role="status"
                                                              aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Pix --}}
                                    <div class="add-funds-form-content d-none">
                                        <h2>Pague via PIX</h2>
                                        <p>Leia o QR Code abaixo com seu aplicativo:</p>
                                        <img src="">

                                        <p>Ou se preferir, utilize o PIX Copia e Cola:</p>
                                        <textarea id="pixPaymentCode" readonly></textarea>
                                        <p class="text-success d-none mt-3 message-pix text-left">Código pix copiado com
                                            sucesso!</p>

                                        <button type="button" class="btn btn-primary btn-min-width mr-1 mb-1 mt-2"
                                                id="pixPaymentCopy">
                                            <i class="fas fa-copy m-1"></i>
                                            Copiar PIX
                                        </button>
                                        <a href="{{ route('panel.payments.index') }}">
                                            <button type="button"
                                                    class="btn round btn-secondary btn-min-width mr-1 mb-1 mt-2">
                                                <i class="fas fa-arrow-left m-1"></i>
                                                Voltar
                                            </button>
                                        </a>
                                    </div>
                                </div>

                                {{-- Cart --}}
                                <div class="tab-pane fade" id="cart" role="tabpanel" aria-labelledby="cart-tab">
                                    <form id="actionAddFundsCartForm" action="#" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="for-group text-center">
                                                    <img src="{{ asset('panel/img/card-logo.png') }}"
                                                         style="max-width: 250px;" alt="pix">
                                                    <p class="p-t-10 mt-2">
                                                        <small>Seu saldo será adicionado automaticamente após o
                                                            pagamento!</small>
                                                    </p>
                                                </div>
                                                <div class="alert alert-danger d-none" id="messageError"></div>
                                                <div class="form-group">
                                                    <label for="priceCard">Valor (BRL)</label>
                                                    <input class="form-control square" type="number" id="priceCard"
                                                           name="price" placeholder="1">
                                                </div>
                                                <div class="form-group">
                                                    <label>Nota:</label>
                                                    <ul>
                                                        <li>
                                                            Insira o valor desejado, clique em gerar <b>Efetuar
                                                                Pagamento</b> e pague usando o Cartão de Crédito;
                                                        </li>
                                                        <li>O valor é adicionado após o pagamento;</li>
                                                    </ul>
                                                </div>

                                                <div class="form-actions">
                                                    <button type="submit"
                                                            class="btn round btn-primary btn-min-width mr-1 mb-1">
                                                        <i class="fas fa-lock m-1"></i>
                                                        EFETUAR PAGAMENTO
                                                        <span class="spinner-border spinner-border-sm ml-1 d-none"
                                                              role="status" aria-hidden="true"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    {{-- Stipe generate --}}
                                    <form id="payment-form" class="d-none mt-2">
                                        <div id="link-authentication-element"></div>
                                        <div id="payment-element"></div>
                                        <button id="submit" class="btn round btn-primary btn-min-width mr-1 mb-1 mt-3">
                                            <i class="fas fa-lock m-1"></i>
                                            <span class="spinner-border spinner-border-sm ml-1 d-none" role="status"
                                                  aria-hidden="true" id="spinner"></span>
                                            <span id="button-text">Pagar agora</span>
                                        </button>
                                        <div id="payment-message" class="hidden text-danger"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 style="margin-left: 16px;">Histórico de saldo </h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Preco</th>
                            <th>Memo</th>
                            <th>Status</th>
                            <th>Data</th>
                        </tr>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
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
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function () {
            jQuery('#actionAddFundsForm').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('panel.payments.store') }}",
                    data: data,
                    dataType: "json",
                    beforeSend: function (response) {
                        form.find('button').attr('disabled', true);
                        form.find('.spinner-border').removeClass('d-none')
                    },
                    success: function (response) {
                        $('#addFunds #actionAddFundsForm').addClass('d-none')
                        $('#addFunds .add-funds-form-content').removeClass('d-none')
                        $('#addFunds .add-funds-form-content img').attr('src', 'data:image/jpeg;base64,' +
                            response.qr_code_base64)
                        $('#addFunds .add-funds-form-content #pixPaymentCode').val(response.qr_code)

                        // Verify Payment
                        verifyPayment(response.url)
                    },
                    error: function (response) {
                        var message = '';
                        $.each(response.responseJSON.errors, function (index, value) {
                            message += value + '<br>';
                        });

                        $('#messageError').removeClass('d-none').html(message)
                    },
                    complete: function (response) {
                        form.find('button').attr('disabled', false);
                        form.find('.spinner-border').addClass('d-none')
                    }
                });

                return false;
            });
        });

        // Copy Pix
        $('#pixPaymentCopy').click(function () {
            navigator.clipboard.writeText($('#pixPaymentCode').val());
            $('.message-pix').removeClass('d-none');

            setTimeout(function () {
                $('.message-pix').addClass('d-none');
            }, 3000);
        })

        // Verify Payment
        function verifyPayment(action) {
            var count = 0

            setInterval(function () {
                $.post(action, function (response) {
                    if (response['status'] == 1 && count == 0) {
                        Swal.fire({
                            title: 'Pagamento confirmado!',
                            text: 'Seu saldo já está disponível em sua conta.',
                            icon: 'success',
                            confirmButtonText: 'Realizar meu pedido',
                        }).then(function () {
                            window.location.href = "{{ route('panel.orders.store') }}";
                        });

                        count++
                    }
                })
            }, 3000)
        }

        // Checkout Stripe
        $('#actionAddFundsCartForm').submit(function (e) {
            e.preventDefault()

            initialize();
            checkStatus();

            $(this).addClass('d-none')
            $('#payment-form').removeClass('d-none')
        })
    </script>
@endpush
