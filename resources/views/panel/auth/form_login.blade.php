@inject('configs', 'App\Services\Web\ConfigService')
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <style>
        :root {
            --color-primary: {{ $configs->config()->color }};
        }
    </style>

    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Entrar - {{ config('app.name') }}</title>
    <meta name="title" content="Entrar - {{ config('app.name') }}">
    {!! SEO::generate() !!}

    <link rel="stylesheet" href="{{ asset(mix('panel/css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('panel/css/all.css')) }}">
    <link rel="canonical" href="{{ URL::current() }}"/>
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="https://via.placeholder.com/189" alt="logo" width="150">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Login</h4></div>

                        <div class="card-body">
                            <form method="POST" action="#" class="needs-validation" novalidate="" id="form-login">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                           required autofocus>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Senha</label>
                                        <div class="float-right">
                                            <a href="{{ route('password.email') }}" class="text-small">
                                                Esqueceu a senha?
                                            </a>
                                        </div>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password"
                                           tabindex="2" required>
                                    <div class="invalid-feedback d-block"></div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        <span class="spinner-border spinner-border-sm mr-1 d-none" role="status"
                                              aria-hidden="true"></span>
                                        Entrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Não tem uma conta? <a href="{{ route('panel.accounts.create') }}">Criar agora</a>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; {{ config('app.name') }} {{ date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset(mix('panel/js/scripts.js')) }}"></script>
<script>
    // Submit form
    jQuery(document).ready(function () {
        jQuery('#form-login').submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            var form = $(this);

            jQuery.ajax({
                type: "POST",
                url: "{{ route('panel.auth.login') }}",
                data: data,
                dataType: "json",
                beforeSend: function (response) {
                    form.find('button').attr('disabled', true);
                    form.find('.spinner-border').removeClass('d-none')
                },
                success: function (response) {
                    window.location.href = '{{ route('panel.index') }}';
                },
                error: function (response) {
                    $('.invalid-feedback').html(response.responseJSON.error)
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
</body>
</html>
