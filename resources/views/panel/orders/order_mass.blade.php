@extends('panel.templates.master')
@section('title', 'Ordem em massa')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Ordem em massa</h1>
            </div>
            <div class="section-body">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="new_order" class="tab-pane fade in active show">
                                <form class="form" id="formOrder" method="POST">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="content-header-title">
                                                <h4><i class="fa fa-shopping-cart"></i> Fazer pedido</h4>
                                            </div>

                                            @if(session('success'))
                                                <div class="alert alert-success mt-4">{!! session('success') !!}</div>
                                            @endif
                                            <div id="messageError" class="alert alert-danger mt-4 d-none"></div>

                                            <div id="mass_order">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <div class="content-header-title mt-3">
                                                            <h6> Um pedido por linha em formato</h6>
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea id="editor" rows="14" name="orders"
                                                                      class="form-control square"
                                                                      style="height: auto !important;"
                                                                      placeholder="service_id | link | quantidade"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <div class="mass_order_error" id="result_notification">
                                                            <div class="content-header-title mt-3">
                                                                <h6><i class="fa fa-info-circle"></i> Obs.:</h6>
                                                            </div>
                                                            <div class="form-group">
                                                                Aqui você pode fazer seus pedidos facilmente! Por
                                                                favor, certifique-se de verificar todos os preços e
                                                                prazos de entrega antes de fazer um pedido!
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions left">
                                                    <button type="submit"
                                                            class="btn round btn-primary btn-min-width mr-1 mb-1">
                                                        <span class="spinner-border spinner-border-sm mr-1 d-none"
                                                              role="status"
                                                              aria-hidden="true"></span>
                                                        ENVIAR PEDIDO
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $("#category").change(function () {
                category()
            })

            function category() {
                const category = $("#category").val()

                let service = '<option value="">Selecione</option>';
                $.get('{{ route('panel.categories.listService') }}', {'category': category}, function (response) {
                    $.each(response, function (index, value) {
                        service += '<option value="' + value.id + '">' + value.name + '</option>';
                    })

                    $('#service').html(service)
                }, 'json').fail(function () {
                    $('#service').html('<option value="">Selecione</option>')
                })
            }

            category()

            $("#service").change(function () {
                const service = $(this).val()

                $.get('{{ route('panel.services.list') }}', {'service': service}, function (response) {
                    $('#minText').html(response.quantity_min)
                    $('#maxText').html(response.quantity_max)
                    $('#serviceName').val(response.name)
                    $('#serviceMin').val(response.quantity_min)
                    $('#serviceMax').val(response.quantity_max)
                    $('#servicePrice').val(response.price * 1000)
                    $('#serviceDesc').val(response.description)

                    $('#quantity').data('price', response.price)

                    if (response.type.id == 3) {
                        $('#quantity').attr('disabled', true)
                        $('.order-comments-custom textarea').attr('disabled', false)
                        $('.order-comments-custom').removeClass('d-none')
                    } else {
                        $('#quantity').attr('disabled', false)
                        $('.order-comments-custom textarea').attr('disabled', true)
                        $('.order-comments-custom').addClass('d-none')
                    }
                }, 'json')
            })

            $('#quantity').keyup(function () {
                const price = $(this).data('price')
                const quantity = $(this).val()

                const total = price * quantity
                const format = total.toLocaleString('pt-br');

                $('#chargeNumber').html('R$ ' + format)
            })

            $('.order-comments-custom textarea').keyup(function (e) {
                const quantity = $(this).val().trim().split("\n").length;
                const price = $('#quantity').data('price');

                const total = price * quantity
                const format = total.toLocaleString('pt-br');

                $('#quantity').val(quantity)
                $('#chargeNumber').html('R$ ' + format)
            });
        })

        // Submit form
        jQuery(document).ready(function () {
            jQuery('#formOrder').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    url: "{{ route('panel.orders.massDo') }}",
                    data: data,
                    dataType: "json",
                    beforeSend: function (response) {
                        form.find('button').attr('disabled', true);
                        form.find('.spinner-border').removeClass('d-none')
                    },
                    success: function (response) {
                        location.reload(true);
                    },
                    error: function (response) {
                        var message = '';
                        $.each(response.responseJSON.errors, function (index, value) {
                            message += value + '<br>';
                        });

                        $('#messageError').removeClass('d-none').html(message)
                        $('.alert-success').addClass('d-none')
                    },
                    complete: function (response) {
                        form.find('button').attr('disabled', false);
                        form.find('.spinner-border').addClass('d-none')
                    }
                });

                return false;
            });
        });
    </script>
@endpush
