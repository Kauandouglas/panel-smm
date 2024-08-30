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
    <title>@yield('title') - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset(mix('panel/css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('panel/css/all.css')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="{{ \Illuminate\Support\Facades\Cookie::get('theme') }}">
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            <form class="form-inline mr-auto">
                <ul class="navbar-nav mr-3">
                    <li>
                        <a href="#">
                            <img src="https://via.placeholder.com/90" alt="" width="90">
                        </a>
                    </li>
                </ul>
            </form>
            <div class="form-inline mr-auto"></div>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown dropdown-list-toggle" id="dropdownNotification">
                    @php
                        $notifications = \App\Models\Notification::
                            where(\Illuminate\Support\Facades\DB::raw('`notifications`.`user_id`'), Auth::id())
                            ->orWhereNull('user_id')->with(['user' => function($query){
                                $query->where('id', Auth::id());
                            }])->where('created_at', '>', Auth::user()->created_at)->latest('id')->limit(20)->get();

                        $notificationCount = 0;
                        foreach ($notifications as $notification) {
                            if ($notification->user == '[]') {
                                $notificationCount++;
                            }
                        }
                    @endphp

                    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg
                        {{ ($notificationCount >= 1 ? 'beep' : '') }}">
                        <i class="fa-regular fa-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Notificações</div>
                        <div class="dropdown-list-content dropdown-list-icons" id="listNotifications"></div>
                    </div>
                </li>
                <li class="dropdown dropdown-list-toggle">
                    <a href="#" class="nav-link nav-link-lg" id="changeTheme">
                        <i class="fa-solid fa-sun"></i>
                    </a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Notificações</div>
                        <div class="dropdown-list-content dropdown-list-icons" id="listNotifications"></div>
                    </div>
                </li>

                <li class="dropdown"><a href="#" data-toggle="dropdown"
                                        class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <img alt="image" src="{{ Auth::user()->get_url_image }}" class="rounded-circle mr-1">
                        <div class="d-sm-none d-lg-inline-block">
                            {{ Auth::user()->name }}
                            <p style="font-size: 11px;margin-top: -13px;position: absolute;">Saldo
                                R$ {{ Auth::user()->convert_balance }}</p>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('panel.accounts.edit') }}" class="dropdown-item has-icon">
                            <i class="far fa-user"></i> Minha conta
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" id="logout" data-action="{{ route('panel.auth.logout') }}"
                           class="dropdown-item has-icon text-danger">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>
                    </div>
                </li>
                <li>
                    <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <div class="main-sidebar sidebar-style-2">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <a href="{{ route('panel.index') }}">
                        <img src="https://via.placeholder.com/150" alt="" width="150"
                             style="padding-top: 20px;padding-bottom: 100px;">
                    </a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{ route('panel.index') }}">
                        <img src="{{ asset('web/img/favicon.png') }}" alt="" width="20"
                             style="padding-top: 20px;padding-bottom: 100px;">
                    </a>
                </div>
                <ul class="sidebar-menu">
                    <li class="menu-header">Dashboard</li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.index') }}">
                            <i class="fas fa-fire"></i><span>Painel</span>
                        </a>
                    </li>

                    <li class="menu-header">Pedidos</li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.orders.create') }}">
                            <i class="fas fa-plus"></i><span>Novo Pedido</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.orders.index') }}">
                            <i class="fas fa-bag-shopping"></i><span>Histórico de Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.orders.mass') }}">
                            <i class="fas fa-box"></i><span>Ordem em Massa</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.refills.index') }}">
                            <i class="fas fa-rotate"></i><span>Histórico de Refil</span>
                        </a>
                    </li>

                    <li class="menu-header">Saldo</li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.payments.index') }}">
                            <i class="fas fa-dollar-sign"></i><span>Adicionar Saldo</span>
                        </a>
                    </li>

                    <li class="menu-header">Serviços</li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.services.index') }}">
                            <i class="fas fa-tags"></i><span>Serviços</span>
                        </a>
                    </li>

                    <li class="menu-header">API</li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.api.index') }}">
                            <i class="fas fa-file-code"></i><span>API</span>
                        </a>
                    </li>

                    <li class="menu-header">Ajuda</li>
                    <li>
                        <a class="nav-link" href="{{ route('panel.supports.index') }}">
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

<a target="_blank"
   href="https://api.whatsapp.com/send?l=pt&amp;phone=555555555555&amp;text=Gostaria+de+Suporte+no">
    <img src="{{ asset('web/img/whatsapp.png') }}"
         style="height:60px; position:fixed; bottom: 15px; right: 15px; z-index:99999;" data-selector="img">
</a>

<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset(mix('panel/js/scripts.js')) }}"></script>
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
                window.location.href = '{{ route('web.home') }}'
            })
        })
    })

    $('#dropdownNotification').on('show.bs.dropdown', function () {
        $('#listNotifications').empty()

        $.get('{{ route('panel.notifications.index') }}', function (response) {
            $('.notification-toggle').removeClass("beep")

            $.each(response, function (index, value) {
                $('#listNotifications').append(`
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="` + value.icon + `"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            ` + value.title + `
                            <div class="time text-primary">` + value.created_at + `</div>
                        </div>
                    </a>
                `);
            })
        }, 'json')
    })

    $('#changeTheme').click(function () {
        $.post('{{ route('panel.theme.change') }}', function () {
            if ($('body').hasClass('dark')) {
                $('body').removeClass('dark')
            } else {
                $('body').addClass('dark')
            }

        }, 'json')
    })
</script>
@stack('scripts')
</body>
</html>
