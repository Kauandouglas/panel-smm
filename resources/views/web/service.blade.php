@extends('web.templates.master')
@section('title', 'Serviços')
@section('content')
    <section class="banner-section inner-banner-section">
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
                            <stop offset="28%" stop-color="rgb(244,245,250)" stop-opacity="1"></stop>
                            <stop offset="100%" stop-color="rgb(252,253,255)" stop-opacity="1"></stop>
                        </linearGradient>

                    </defs>
                    <path fill-rule="evenodd" opacity="0.1" fill="rgb(0, 0, 0)"
                          d="M480.084,0.001 L1290.991,0.001 L810.906,831.000 L-0.000,831.000 L480.084,0.001 Z"></path>
                    <path fill="url(#PSgrad_0)"
                          d="M480.084,0.001 L1290.991,0.001 L810.906,831.000 L-0.000,831.000 L480.084,0.001 Z"></path>
                </svg>
            </figure>
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="banner-content">
                        <h2 class="title">Serviços</h2>
                        <div class="breadcrumb-area">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('web.home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Serviços</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container mt-5">
        <div class="table-responsive">
            @foreach($categories as $category)
                <table class="table table-bordered shadow">
                    <thead>
                    <tr>
                        <th scope="col" colspan="5">{{ $category->name }}</th>
                    </tr>
                    <tr>
                        <th scope="col" class="bg-white">ID</th>
                        <th scope="col" class="bg-white">Nome</th>
                        <th scope="col" class="bg-white">Preço por cada 1000(R$)</th>
                        <th scope="col" class="bg-white">Min / Max por Pedido</th>
                        <th scope="col" class="bg-white">Descrição</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category->services as $service)
                        <tr>
                            <th scope="row">{{ $service->id }}</th>
                            <th>{{ $service->name }}</th>
                            <th>R$ {{ $service->price }}</th>
                            <th>{{ $service->quantity_min }} / {{ $service->quantity_max }}</th>
                            <th>
                                <button class="cmn-btn" data-toggle="modal" data-target="#descriptionModal"
                                        data-description="{{ nl2br($service->description) }}"
                                        data-title="{{ $service->name }}">
                                    Detalhes
                                </button>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#descriptionModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes
            var description = button.data('description') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text(title)
            modal.find('.modal-body').html(description)
        })

    </script>
@endpush

