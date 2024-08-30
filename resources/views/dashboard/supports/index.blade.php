@extends('dashboard.templates.master')
@section('title', 'Suporte')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Suporte</h1>
            </div>
            <div class="section-body">
                <div class="section-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-6">
                            <div class="card shadow overflow-auto">
                                <div class="card-header">
                                    <h4>Conversas</h4>
                                </div>
                                <div class="card-body" style="height: 352px;">
                                    <ul class="list-unstyled list-unstyled-border">
                                        @foreach($supports as $support)
                                            <li class="media"
                                                style="border-bottom: 1px solid #e1e1e1ad; cursor: pointer">
                                                <a href="{{ route('dashboard.supports.index', ['support' => $support]) }}"
                                                   class="text-decoration-none text-black-50 w-100">
                                                    <div class="media-body">
                                                        <div
                                                            class="mt-0 mb-1 font-weight-bold">{{ $support->subject }}</div>
                                                        <small>{{ $support->convert_date }}</small>
                                                        @if($support->status == 0)
                                                            <p class="text-warning">{{ $support->status_string }}</p>
                                                        @elseif($support->status == 1)
                                                            <p class="text-success">{{ $support->status_string }}</p>
                                                        @else
                                                            <p class="text-danger">{{ $support->status_string }}</p>
                                                        @endif
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-6">
                            <div class="card chat-box card-success shadow" id="mychatbox2">
                                @if($supportFind)
                                    <div class="card-header">
                                        <h4>#{{ $supportFind->id }} - {{ $supportFind->subject }}</h4>
                                        @if($supportFind->status != 2)
                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#finishModal">Finalizar
                                            </button>
                                        @endif
                                    </div>
                                    <div class="card-body chat-content" id="chatMessage">
                                        @foreach($supportMessages as $supportMessage)
                                            <div class="chat-item
                                                {{ ($supportMessage->send_admin == 1 ? 'chat-right' : 'chat-left') }}">
                                                <img src="{{ Auth::user()->get_url_image }}">
                                                <div class="chat-details">
                                                    <div class="chat-text">{{ $supportMessage->message }}</div>
                                                    <div class="chat-time">{{ $supportMessage->convert_time }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="card-footer chat-form">
                                        @if($supportFind->status == 0 || $supportFind->status == 1)
                                            <form id="chat-form2" method="POST"
                                                  action="{{ route('dashboard.supportMessages.store', ['support' => $supportFind]) }}">
                                                @csrf
                                                <input type="text" class="form-control" name="message"
                                                       placeholder="Digite sua mensagem...">
                                                <button class="btn btn-primary">
                                                    <i class="far fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form id="chat-form2" method="POST">
                                                <input type="text" class="form-control" name="message"
                                                       placeholder="Esse suporte está {{ $supportFind->status_string }}!"
                                                       disabled>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    <div class="card-body chat-content justify-content-center text-center m-auto"
                                         style="padding-top: 70px !important; height: 420px">
                                        <h2 class="mt-5">Criar solicitação de suporte</h2>
                                        <p class="mt-4">
                                            Antes de criar uma solicitação, verifique a seção Perguntas frequentes. Se
                                            você não conseguir encontrar a resposta que está procurando, clique em para
                                            criar uma solicitação de suporte.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal --}}
    @if($supportFind)
        <div class="modal fade" tabindex="-1" role="dialog" id="finishModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Finalizar suporte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Voce realmente deseja finalizar o suporte?</p>
                        <form method="POST"
                              action="{{ route('dashboard.supports.finish', ['support' => $supportFind]) }}">
                            @csrf
                            <div class="modal-footer br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-danger">Finalizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('scripts')
    <script>
        $(function () {
            jQuery('#chat-form2').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        const d = new Date();
                        let h = d.getHours();
                        let m = d.getMinutes();

                        var message = `<div class="chat-item chat-right">
                            <img src="{{ Auth::user()->get_url_image }}">
                            <div class="chat-details">
                                <div class="chat-text">` + form.find('input[name="message"]').val() + `</div>
                                <div class="chat-time">` + h + `:` + m + `</div>
                            </div>
                        </div>`;
                        $('#chatMessage').append(message)

                        form.find('input[name="message"]').val('')

                        // Move Scroll Button
                        $("#chatMessage").scrollTop($("#chatMessage")[0].scrollHeight);
                    },
                    error: function (response) {
                        alert("Ocorreu um erro ao enviar sua mensagem!")
                    },
                });

                return false;
            });
        })

        // Move Scroll Button
        $("#chatMessage").scrollTop($("#chatMessage")[0].scrollHeight);
    </script>
@endpush
