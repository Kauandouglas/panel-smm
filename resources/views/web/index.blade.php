@extends('web.templates.master')
@section('title', 'Painel Seguidores Oficial: Tenha mais curtidas e visualizações!🏅')
@section('content')
    <!-- banner-section start -->
    <section class="banner-section">
        <div class="banner-shape-one">
            <img src="{{ asset('web/img/icon-1.png') }}" alt="shape">
        </div>
        <div class="banner-shape-two">
            <img src="{{ asset('web/img/icon-2.png') }}" alt="shape">
        </div>
        <div class="banner-shape-three">
            <img src="{{ asset('web/img/icon-3.png') }}" alt="shape">
        </div>
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-right">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1291px"
                     height="480px">
                    <defs>
                        <linearGradient id="PSgrad_0" x1="0%" x2="0%" y1="100%" y2="0%">
                            <stop offset="28%" stop-color="rgb(244,245,250)" stop-opacity="1"/>
                            <stop offset="100%" stop-color="rgb(252,253,255)" stop-opacity="1"/>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" opacity="0.1" fill="rgb(0, 0, 0)"
                          d="M480.084,0.001 L1290.991,0.001 L810.906,831.000 L-0.000,831.000 L480.084,0.001 Z"/>
                    <path fill="url(#PSgrad_0)"
                          d="M480.084,0.001 L1290.991,0.001 L810.906,831.000 L-0.000,831.000 L480.084,0.001 Z"/>
                </svg>
            </figure>
            <div class="row align-items-center" style="position: relative;margin-top: -40px;">
                <div class="col-lg-6">
                    <div class="banner-content">
                        <h1 class="title" style="text-transform: none">Aumente o número de seguidores, curtidas,
                            comentários e visualizações a partir de 1 Real </h1>
                        <p> Expanda sua presença no Instagram, TikTok e demais plataformas sociais. </p>
                        <div class="banner-btn">
                            <a href="{{ route('panel.auth.formLogin') }}" class="cmn-btn-active mr-2">Entrar</a>
                            <a href="{{ route('panel.accounts.create') }}" class="cmn-btn mb-0">Cadastra-se</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="banner-element" data-toggle="modal" data-target="#videoModal">
                        <img src="{{ asset('437x9gniwc7f39qx.gif') }}"
                             alt="Vídeo de apresentação {{ config('app.name') }}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner-section end -->

    <!-- Modal Video -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe width="768" height="350" class="mw-100" src="https://www.youtube.com/embed/i1k6o74iRfw"
                            title="Hungria - Coração de Carro Forte" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>


    <!-- feature-section start -->
    <section class="feature-section ptb-80">
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                     height="480px">
                    <defs>
                        <linearGradient id="PSgrad_1" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                            <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"/>
                            <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"/>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                    <path fill="url(#PSgrad_1)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                </svg>
            </figure>
            <div class="row justify-content-center ml-b-30">

                <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                    <div class="feature-item text-center">
                        <div class="feature-icon">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <div class="feature-content">
                            <h3 class="title">Menor preço</h3>
                            <p>Obtenha todos os serviços da plataforma com os preços mais baixos do Brasil.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                    <div class="feature-item text-center">
                        <div class="feature-icon">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div class="feature-content">
                            <h3 class="title">Serviços Ultra Rápidos</h3>
                            <p>Desfrute dos serviços mais rápidos disponíveis, entregues em tempo recorde 24 horas por
                                dia.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8 mrb-30">
                    <div class="feature-item text-center">
                        <div class="feature-icon">
                            <i class="fa-solid fa-gift"></i>
                        </div>
                        <div class="feature-content">
                            <h3 class="title">Descontos exclusivos</h3>
                            <p>Aproveite descontos exclusivos que aumentam à medida que suas vendas crescem.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- feature-section end -->
    <!-- about-section start -->
    <section class="about-section ptb-80" id="about">
        <div class="about-shape-one">
            <img src="{{ asset('web/img/icon-1.png') }}" alt="shape">
        </div>
        <div class="about-shape-two">
            <img src="{{ asset('web/img/icon-2.png') }}" alt="shape">
        </div>
        <div class="about-shape-three">
            <img src="{{ asset('web/img/icon-3.png') }}" alt="shape">
        </div>
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                     height="480px">
                    <defs>
                        <linearGradient id="PSgrad_2" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                            <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"/>
                            <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"/>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                    <path fill="url(#PSgrad_2)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                </svg>
            </figure>
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-6 mrb-30">
                    <div class="about-thumb">
                        <img src="{{ asset('web/img/606863bb72e421617454011.png') }}"
                             alt="Seguidores para todas Redes sociais">
                    </div>
                </div>
                <div class="col-lg-6 mrb-30">
                    <div class="about-content">
                        <h2 class="title">Tenha acesso a uma plataforma exclusiva e moderna que simplifica o seu
                            trabalho</h2>
                        <span class="title-border"></span>
                        <p>Além dos serviços essenciais, disponibilizamos as mais recentes tecnologias do mercado global
                            para tornar o seu dia mais fácil. Desfrute de um sistema de reposição totalmente funcional e
                            acompanhe em tempo real o status de todos os seus pedidos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-section end -->
    <!-- about-section start -->
    <section class="about-section ptb-80">
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                     height="480px">
                    <defs>
                        <linearGradient id="PSgrad_2" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                            <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"/>
                            <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"/>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                    <path fill="url(#PSgrad_2)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                </svg>
            </figure>
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-6 mrb-30">
                    <div class="about-content">
                        <h2 class="title">
                            Suporte disponível 24/7
                        </h2>
                        <span class="title-border"></span>
                        <p>Tão importante quanto contar com excelentes serviços, o suporte é fundamental para o sucesso
                            do seu negócio. É por isso que oferecemos um suporte dedicado à sua disposição todos os dias
                            da semana, 24 horas por dia. </p>
                    </div>
                </div>
                <div class="col-lg-6 mrb-30">
                    <div class="about-thumb-two">
                        <img src="{{ asset('web/img/606865d1b74881617454545.png') }}"
                             alt="Suporte disponível todos os dias">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-section end -->
    <!-- about-section start -->
    <section class="about-section ptb-80">
        <div class="about-shape-one">
            <img src="{{ asset('web/img/icon-1.png') }}" alt="shape">
        </div>
        <div class="about-shape-two">
            <img src="{{ asset('web/img/icon-2.png') }}" alt="shape">
        </div>
        <div class="about-shape-three">
            <img src="{{ asset('web/img/icon-3.png') }}" alt="shape">
        </div>
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                     height="480px">
                    <defs>
                        <linearGradient id="PSgrad_2" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                            <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"/>
                            <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"/>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                    <path fill="url(#PSgrad_2)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                </svg>
            </figure>
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-6 mrb-30">
                    <div class="about-thumb">
                        <img src="{{ asset('web/img/presentation-2.png') }}" alt="Menor preço do nosso serviços">
                    </div>
                </div>
                <div class="col-lg-6 mrb-30">
                    <div class="about-content">
                        <h2 class="title">Os preços mais baixos do Brasil e promoções diárias</h2>
                        <span class="title-border"></span>
                        <p>Diga adeus aos altos preços dos serviços de SMM, aqui você encontrará preços de custo. Além
                            do preço competitivo, oferecemos o melhor suporte do Brasil. Também possuímos o selo de
                            qualidade em todos os nossos serviços. Cadastre-se agora mesmo e descubra toda a nossa
                            estrutura.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-section end -->
    <!-- counter-section start -->
    <section class="counter-section ptb-80">
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                     height="480px">
                    <defs>
                        <linearGradient id="PSgrad_4" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                            <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"/>
                            <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"/>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                    <path fill="url(#PSgrad_4)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                </svg>
            </figure>
            <div class="row justify-content-center ml-b-10">
                <div class="col-lg-3 col-md-6 col-sm-6 mrb-10">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div class="counter-content">
                            <div class="odo-area">
                                <h3 class="odo-title odometer" data-odometer-final="2146622">0</h3>
                            </div>
                            <p>TOTAL DE PEDIDOS</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mrb-10">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="counter-content">
                            <div class="odo-area">
                                <h3 class="odo-title odometer" data-odometer-final="22003">0</h3>
                            </div>
                            <p>USUÁRIOS ATIVOS</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mrb-10">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <div class="counter-content">
                            <div class="odo-area">
                                <h3 class="odo-title odometer" data-odometer-final="245">0</h3>
                            </div>
                            <p>SERVIÇOS ATIVOS</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mrb-10">
                    <div class="counter-item">
                        <div class="counter-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="counter-content">
                            <div class="odo-area">
                                <h3 class="odo-title odometer" data-odometer-final="15412">0</h3>
                            </div>
                            <p>Total suporte</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="action-section ptb-80 bg_img" style="background-color: var(--color-primary)">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="action-content">
                        <span class="sub-title">Líder do mercado {{ date('Y') }}</span>
                        <h2 class="title">Eleve o seu serviço a um patamar superior.</h2>
                        <div class="action-btn">
                            <a href="{{ route('panel.auth.formLogin') }}" class="cmn-btn-active">Comece agora</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- action-section end -->

    <!-- faq-section start -->
    <section class="faq-section ptb-80">
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                     height="480px">
                    <defs>
                        <linearGradient id="PSgrad_4" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                            <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"/>
                            <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"/>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                    <path fill="url(#PSgrad_4)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                </svg>
            </figure>
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="section-header">
                        <span class="sub-title">Faq</span>
                        <h2 class="section-title">Perguntas frequentes</h2>
                        <span class="title-border"></span>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6 mrb-30">
                    <div class="faq-wrapper">
                        <div class="faq-item ">
                            <h3 class="faq-title"><span
                                    class="title">Quais serviços posso encontrar neste painel?</span><span
                                    class="right-icon"></span></h3>
                            <div class="faq-content">
                                <p>Oferecemos uma variedade de serviços para impulsionar suas redes sociais, incluindo
                                    seguidores, curtidas, visualizações, comentários e muito mais.</p>
                            </div>
                        </div>
                        <div class="faq-item ">
                            <h3 class="faq-title"><span
                                    class="title">Quais são os riscos de banir minha conta?</span><span
                                    class="right-icon"></span></h3>
                            <div class="faq-content">
                                <p>Nossa abordagem garante um risco 0, pois nossos serviços são entregues de forma
                                    gradual e natural, garantindo resultados autênticos e orgânicos.</p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 mrb-30">
                    <div class="faq-thumb">
                        <img src="{{ asset('web/img/60686dd6ea4bf1617456598.png') }}" alt="Total de impressão">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- faq-section end -->
    <!-- client-section-two start -->
    <div class="client-section ptb-80 bg_img" style="background-color: var(--color-primary)">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-header">
                        <h2 class="section-title">Nossos clientes falam por nós!</h2>
                        <span class="title-border"></span>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center ml-b-20">
                <div class="col-lg-12">
                    <div class="client-slider">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="client-item">
                                    <div class="client-content">
                                        <div class="client-details">
                                            <div class="client-ratings">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <p>Estou extremamente satisfeito com a experiência de utilizar os serviços
                                                oferecidos por vocês. A rapidez e eficiência são incríveis e têm sido de
                                                grande benefício para os meus clientes.</p>
                                        </div>
                                        <div class="client-bottom">
                                            <div class="client-thumb">
                                                <img src="{{ asset('web/img/0mbxnl5owq7u3kg0.png') }}"
                                                     alt="client">
                                            </div>
                                            <div class="client-title">
                                                <h3 class="title">Lucas Sousa</h3>
                                                <span class="sub-title">Usuário</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="client-item">
                                    <div class="client-content">
                                        <div class="client-details">
                                            <div class="client-ratings">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <p>Muito bom. Estou curtindo usar os serviços de vocês. Muito rápido e isso
                                                ajuda demais para meus
                                                clientes.</p>
                                        </div>
                                        <div class="client-bottom">
                                            <div class="client-thumb">
                                                <img src="{{ asset('web/img/0mbxnl5owq7u3kg0.png') }}"
                                                     alt="client">
                                            </div>
                                            <div class="client-title">
                                                <h3 class="title">Anderson Gomes</h3>
                                                <span class="sub-title">Usuário</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="client-item">
                                    <div class="client-content">
                                        <div class="client-details">
                                            <div class="client-ratings">
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </div>
                                            <p>Se você está em busca de uma plataforma confiável e de alta qualidade, eu
                                                recomendo esta sem hesitação. Estou utilizando há vários meses e sempre
                                                a indico para outras pessoas.</p>
                                        </div>
                                        <div class="client-bottom">
                                            <div class="client-thumb">
                                                <img src="{{ asset('web/img/0mbxnl5owq7u3kg0.png') }}"
                                                     alt="client">
                                            </div>
                                            <div class="client-title">
                                                <h3 class="title">Sofia marques</h3>
                                                <span class="sub-title">Usuário</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- client-section-two end -->

    <section class="call-to-action-section ptb-80">
        <div class="container">
            <figure class="figure highlight-background highlight-background--lean-left">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="1439px"
                     height="480px">
                    <defs>
                        <linearGradient id="PSgrad_4" x1="42.262%" x2="0%" y1="90.631%" y2="0%">
                            <stop offset="28%" stop-color="rgb(245,246,252)" stop-opacity="1"/>
                            <stop offset="100%" stop-color="rgb(255,255,255)" stop-opacity="1"/>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" fill="rgb(255, 255, 255)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                    <path fill="url(#PSgrad_4)"
                          d="M863.247,-271.203 L-345.788,-427.818 L760.770,642.200 L1969.805,798.815 L863.247,-271.203 Z"/>
                </svg>
            </figure>
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 text-center">
                    <div class="call-to-action-content">
                        <h2 class="title">Assine nossas redes</h2>
                        <form class="call-to-action-form" method="post" action="" id="subscribeForm">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <input type="email" id="subscribe" name="email" value=""
                                           placeholder="Seu endereço de Email" required>
                                    <button type="submit" class="submit-btn subscribe_btn">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
