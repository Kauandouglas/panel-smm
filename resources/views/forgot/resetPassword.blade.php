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
    <title>Alterar senha - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset(mix('panel/css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('panel/css/all.css')) }}">
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
                        <div class="card-header"><h4>Alterar senha</h4></div>

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

                            <form method="POST"
                                  action="{{ route('password.update', ['token' => request()->token, 'email' => request()->email]) }}"
                                  class="needs-validation" novalidate="" id="form-login">
                                @csrf
                                <div class="form-group">
                                    <label for="password">Senha</label>
                                    <input id="password" type="password" class="form-control" name="password"
                                           tabindex="1" required autofocus>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Alterar senha
                                    </button>
                                </div>
                            </form>
                        </div>
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
</body>
</html>
