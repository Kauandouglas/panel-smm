@inject('configs', 'App\Services\Web\ConfigService')
<!DOCTYPE html>
<html lang="pt-bR">
<head>
    <style>
        :root {
            --color-primary: {{ $configs->config()->color }};
        }
    </style>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Dashboard - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset(mix('dashboard/css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('dashboard/css/all.css')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </form>
            <div class="form-inline mr-auto"></div>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown"
                       class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ Auth::user()->get_url_image }}" class="rounded-circle mr-1">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('dashboard.configs.edit') }}" class="dropdown-item has-icon">
                            <i class="far fa-edit"></i> Tema
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" id="logout" data-action="{{ route('dashboard.auth.logout') }}"
                           class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{ route('dashboard.index') }}">
                        <img src="https://via.placeholder.com/189" alt="" width="150"
                             style="padding-top: 20px;padding-bottom: 100px;">
                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{ route('dashboard.index') }}">
                        <img src="{{ asset('web/img/favicon.png') }}" alt="" width="20"
                             style="padding-top: 20px;padding-bottom: 100px;">
                    </a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">Dashboard</li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.index') }}">
                            <i class="fas fa-fire"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.links.index') }}">
                            <i class="fas fa-link"></i><span>Links</span>
                        </a>
                    </li>

                    <li class="menu-header">Usuários</li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.users.index') }}">
                            <i class="fas fa-user"></i><span>Usuários</span>
                        </a>
                    </li>

                    <li class="menu-header">Pedidos</li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.orders.index') }}">
                            <i class="fas fa-bag-shopping"></i><span>Histórico de Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.refills.index') }}">
                            <i class="fas fa-rotate"></i><span>Histórico de Refill</span>
                        </a>
                    </li>

                    <li class="menu-header">Saldo</li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.payments.index') }}">
                            <i class="fas fa-dollar-sign"></i><span>Pagamentos</span>
                        </a>
                    </li>

                    <li class="menu-header">Serviços</li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.services.index') }}">
                            <i class="fas fa-tags"></i><span>Serviços</span>
                        </a>
                    </li>

                    <li class="menu-header">Relatórios</li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.reports.order') }}">
                            <i class="fas fa-file-contract"></i><span>Relatório</span>
                        </a>
                    </li>

                    <li class="menu-header">Apis</li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.apis.index') }}">
                            <i class="fas fa-code"></i><span>Provedores de API</span>
                        </a>
                    </li>

                    <li class="menu-header">Ajuda</li>
                    <li>
                        <a class="nav-link" href="{{ route('dashboard.supports.index') }}">
                            <i class="fas fa-headset"></i><span>Suporte</span>
                        </a>
                    </li>
                </ul>
            </aside>
        </div>
        @yield('content')

        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; {{ date('Y') }}
                <div class="bullet"></div>
                {{ config('app.name') }}
            </div>
            <div class="footer-right">

            </div>
        </footer>
    </div>
</div>


<script src="{{ asset(mix('dashboard/js/scripts.js')) }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#logout').click(function (e) {
            e.preventDefault()

            $.post($(this).data('action'), function () {
                document.location.reload();
            })
        })
    })
</script>
@stack('scripts')
</body>
</html>
