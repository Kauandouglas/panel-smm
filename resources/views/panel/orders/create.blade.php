@extends('panel.templates.master')
@section('title', 'Novo Pedido')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Novo Pedido</h1>
            </div>
            <div class="section-body">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="new_order" class="tab-pane fade in active show">
                                <form class="form" id="formOrder" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="content-header-title">
                                                <h4><i class="fa fa-shopping-cart"></i> Fazer pedido</h4>
                                            </div>

                                            @if(session('success'))
                                                <div class="alert alert-success mt-4">{!! session('success') !!}</div>
                                            @endif
                                            <div id="messageError" class="alert alert-danger mt-4 d-none"></div>

                                            <div class="form-group">
                                                <label for="category">Escolha uma Categoria:</label>
                                                <select name="category" class="form-control square" id="category">
                                                    <option value="">Selecione</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group" id="result_onChange">
                                                <label for="service">Selecione um Serviço:</label>
                                                <select name="service_id" class="form-control square" id="service">
                                                    <option value="">Selecione</option>
                                                </select>
                                            </div>

                                            <div class="form-group order-default-link">
                                                <label for="link">Insira o Link:</label>
                                                <input class="form-control square" type="text" name="link"
                                                       placeholder="https://" id="link">
                                            </div>

                                            <div class="form-group order-default-quantity">
                                                <label for="quantity">Coloque a Quantidade:</label>
                                                <input class="form-control square" min="1" name="quantity" type="number"
                                                       id="quantity" data-price="0.00">
                                                <small class="mr-2">Minino: <span id="minText"></span></small>
                                                <small>Máximo: <span id="maxText"></span></small>
                                            </div>

                                            <div class="form-group order-comments-custom d-none">
                                                <label for="comments">Comentários</label>
                                                <textarea rows="10" name="comments" id="comments" disabled
                                                          class="form-control square"></textarea>
                                            </div>

                                            <!-- Subscriptions  -->
                                            <div class="row order-subscriptions d-none">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Usuário</label>
                                                        <input class="form-control square" type="text"
                                                               name="sub_username">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Próximos Posts</label>
                                                        <input class="form-control square" type="number"
                                                               placeholder="mínimo 1 post" name="sub_posts">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Coloque a Quantidade:</label>
                                                        <input class="form-control square" type="number" name="sub_min"
                                                               placeholder="min">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <input class="form-control square" type="number" name="sub_max"
                                                               placeholder="max">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Atraso (Tempo para começar a entrar) (minutos)</label>
                                                        <select name="sub_delay" class="form-control square">
                                                            <option value="0">Mais rápido possível</option>
                                                            <option value="5">5</option>
                                                            <option value="10">10</option>
                                                            <option value="15">15</option>
                                                            <option value="30">30</option>
                                                            <option value="60">60</option>
                                                            <option value="90">90</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Expiração</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control datepicker"
                                                                   name="sub_expiry" onkeydown="return false"
                                                                   placeholder="" id="expiry">
                                                            <span class="input-group-append">
                            <button class="btn btn-info" type="button"
                                    onclick="document.getElementById('expiry').value = ''"><i class="fe fe-trash-2"></i></button>
                          </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="result_total_charge">
                                                <p class="btn btn-info total_charge">Valor a Pagar
                                                    <span id="chargeNumber">R$ 0</span>
                                                </p>
                                            </div>

                                            <div>
                                                <p>ATENÇÃO: O Perfil não pode está Privado | E confirme se o Link acima
                                                    está correto</p>
                                            </div>

                                            <div class="form-actions left">
                                                <button type="submit"
                                                        class="btn round btn-primary btn-min-width mr-1 mb-1">
                                                    <span class="spinner-border spinner-border-sm mr-1 d-none"
                                                          role="status" aria-hidden="true"></span>
                                                    ENVIAR PEDIDO
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-6 order_resume mt-5" id="order_resume">
                                            <div class="content-header-title">
                                                <h4><i class="fa fa-shopping-cart"></i> Descrição</h4>
                                            </div>
                                            <div class="row" id="result_onChangeService">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>Nome do Serviço</label>
                                                        <input class="form-control square" id="serviceName"
                                                               type="text" autocomplete="off" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-4  col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>Quantidade mínima</label>
                                                        <input class="form-control square" id="serviceMin"
                                                               type="text" autocomplete="off" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-4  col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>Quantidade máxima</label>
                                                        <input class="form-control square" id="serviceMax"
                                                               type="text" autocomplete="off" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-4  col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label>Preço por cada 1000</label>
                                                        <input class="form-control square" id="servicePrice"
                                                               type="text" autocomplete="off" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="userinput8">Descrição e Resumo</label>
                                                        <textarea rows="10" id="serviceDesc" autocomplete="off"
                                                                  style="height: auto !important;"
                                                                  class="form-control square" disabled></textarea>
                                                    </div>
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

            function formatPrice(valor) {
                const formatter = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });

                return formatter.format(valor);
            }

            function category() {
                const category = $("#category").val()

                let service = '<option value="">Selecione</option>';
                $.get('{{ route('panel.categories.listService') }}', {'category': category}, function (response) {
                    $.each(response, function (index, value) {
                        var price = formatPrice(value.price)
                        service += '<option value="' + value.id + '">' + value.id + ' - ' + value.name +
                            ' - ' + price + ' por 1000' +
                            '</option>';
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
                    $('#servicePrice').val(response.price.toLocaleString('pt-br'))
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

                const total = (price / 1000) * quantity
                const format = total.toLocaleString('pt-br');

                $('#chargeNumber').html('R$ ' + format)
            })

            $('.order-comments-custom textarea').keyup(function (e) {
                const quantity = $(this).val().trim().split("\n").length;
                const price = $('#quantity').data('price');

                const total = (price / 1000) * quantity
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
                    url: "{{ route('panel.orders.store') }}",
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
