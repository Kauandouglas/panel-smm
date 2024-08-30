@extends('panel.templates.master')
@section('title', 'Minha conta')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Minha conta</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title">Informações Básicas</h3>
                            </div>

                            <div class="card-body">
                                <form class="form actionForm" id="editProfile" method="POST">
                                    <div id="messageSuccess" class="alert alert-success mt-4 d-none"></div>
                                    <div id="messageError" class="alert alert-danger mt-4 d-none"></div>

                                    @csrf
                                    @method('PUT')
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="name">Nome</label>
                                                    <input class="form-control square" name="name" type="text"
                                                           value="{{ Auth::user()->name }}" id="name">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="email">E-mail</label>
                                                    <input class="form-control square" name="email" type="email"
                                                           value="{{ Auth::user()->email }}" id="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="image">Foto</label>
                                                    <input class="form-control square" name="image" type="file"
                                                           value="{{ Auth::user()->image }}" id="image"
                                                           accept="image/*">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="phone">Celular</label>
                                                    <input class="form-control square" name="phone" type="text"
                                                           value="{{ Auth::user()->phone }}" id="phone" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="password">Senha</label>
                                                    <input class="form-control square" name="password" type="password"
                                                           id="password">
                                                    <small class="text-primary">Nota: Se você não quiser alterar a
                                                        senha, deixe esses campos de senha em branco!</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirme a senha</label>
                                                    <input class="form-control square" name="password_confirmation"
                                                           type="password" id="password_confirmation">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12 form-actions">
                                                <div class="p-l-10">
                                                    <button type="submit"
                                                            class="btn round btn-primary btn-min-width mr-1 mb-1">
                                                         <span class="spinner-border spinner-border-sm mr-1 d-none"
                                                               role="status"
                                                               aria-hidden="true"></span>
                                                        Salvar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-header">
                                <h3 class="card-title">Sua Chave de API</h3>
                                <div class="card-options">
                                    <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i
                                            class="fe fe-chevron-up"></i></a>
                                    <a href="#" class="card-options-remove" data-toggle="card-remove"><i
                                            class="fe fe-x"></i></a>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="form actionForm" action="{{ route('panel.accounts.token') }}"
                                      method="POST">
                                    @csrf

                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="form-group">
                                        <label for="api_key">Chave</label>
                                        <div class="input-group">
                                            <input type="text" name="api_key" class="form-control square"
                                                   value="{{ Auth::user()->api_key }}" id="api_key" readonly>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
                                         <span class="spinner-border spinner-border-sm mr-1 d-none"
                                               role="status"
                                               aria-hidden="true"></span>
                                        Gerar nova
                                    </button>
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
        jQuery(document).ready(function () {
            jQuery('#editProfile').submit(function () {
                var data = new FormData(this);
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    data: data,
                    url: "{{ route('panel.accounts.update') }}",
                    responseType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function (response) {
                        form.find('button').attr('disabled', true);
                        form.find('.spinner-border').removeClass('d-none')
                    },
                    success: function (response) {
                        $('#editProfile #messageError').addClass('d-none')
                        $('#editProfile .alert-success').removeClass('d-none').html(response.message)
                    },
                    error: function (response) {
                        var message = '';
                        $.each(response.responseJSON.errors, function (index, value) {
                            message += value + '<br>';
                        });

                        $('#editProfile #messageError').removeClass('d-none').html(message)
                        $('#editProfile .alert-success').addClass('d-none')
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
