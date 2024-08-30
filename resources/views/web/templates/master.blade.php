@inject('configs', 'App\Services\Web\ConfigService')
    <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <style>
        :root {
            --color-primary: {{ $configs->config()->color }};
        }
    </style>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta name="title" content="{{ config('app.name') }} - @yield('title')">
    {!! SEO::generate() !!}

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}"
          type="image/x-icon">

    <link rel="apple-touch-icon" href="{{ asset('web/img/logo.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }} - @yield('title')">

    <meta itemprop="name" content="{{ config('app.name') }} - @yield('title')">
    <meta itemprop="image" content="{{ asset('web/img/606859a23e2531617451426.png') }}">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(mix('web/css/app.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('web/css/all.css')) }}">
</head>
<body>
<!-- header-section start -->
<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ route('web.home') }}"><img
                                src="https://via.placeholder.com/189" height="34px"
                                alt="{{ config('app.name') }}" title="{{ config('app.name') }}"></a>
                        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ml-auto">
                                <li><a href="{{ route('web.home') }}">Home</a></li>
                                <li><a href="{{ route('web.service') }}">Serviços</a></li>

                                <li>
                                    <a href="{{ route('panel.auth.formLogin') }}"
                                       style="padding: 10px 0px 10px 0;font-size: 16px;margin-top: 9px;width: 120px;text-align: center; margin-left: 15px;"
                                       class="cmn-btn-active">Entrar</a>
                                </li>
                                <li>
                                    <a href="{{ route('panel.accounts.create') }}"
                                       style="padding: 10px 0px 10px 0;font-size: 16px;margin-top: 9px;width: 120px;text-align: center;color: #fff; margin-left: 15px;"
                                       class="cmn-btn">Cadastrar</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-section end -->

<a target="_blank"
   href="https://api.whatsapp.com/send?l=pt&amp;phone=555555555555&amp;text=Gostaria+de+Suporte">
    <img src="{{ asset('web/img/whatsapp.png') }}" alt="Nosso Contato Pelo Whatsapp"
         style="height:60px; position:fixed; bottom: 15px; right: 15px; z-index:99999;" data-selector="img">
</a>

@yield('content')

<footer class="footer-section ptb-80">
    <div class="container">
        <div class="footer-area mrt-100">
            <div class="row ml-b-30">
                <div class="col-lg-4 col-sm-8 mrb-30">
                    <div class="footer-widget widget-menu">
                        <div class="footer-logo">
                            <h3 class="widget-title">Sobre nós</h3>
                            <p>Uma plataforma exclusiva e moderna para facilitar o seu trabalho</p>
                            <div class="social-area">
                                <ul class="footer-social">
                                    <li><a href="https://www.facebook.com/"><i class="lab la-facebook-f"></i></a></li>
                                    <li><a href="https://www.twitter.com/"><i class="lab la-twitter"></i></a></li>
                                    <li><a href="https://www.instagram.com/"><i class="lab la-instagram"></i></a></li>
                                    <li><a href="https://www.google.com/"><i class="lab la-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 mrb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">Link rápido</h3>
                        <ul>
                            <li><a href="{{ route('web.home') }}">Home</a></li>
                            <li><a href="{{ route('web.service') }}">Serviços</a></li>
                            <li><a href="{{ route('panel.auth.formLogin') }}">Entrar</a></li>
                            <li><a href="{{ route('panel.accounts.create') }}">Cadastrar</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mrb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">Privacidade e Termos</h3>
                        <ul>
                            <li><a href="{{ route('web.term') }}">Termos de uso</a></li>
                            <li><a href="{{ route('web.privacy') }}">Privacidade</a></li>
                            <li><a href="">API Documentação</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="privacy-area privacy-area--style">
    <div class="container">
        <div class="copyright-area d-flex flex-wrap align-items-center justify-content-center">
            <div class="copyright">
                <p>Copyright © {{ date('Y') }} Todos os direitos reservados</p>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset(mix('web/js/scripts.js')) }}"></script>
@stack('scripts')
</body>
</html>
