@extends('dashboard.templates.master')
@section('title', 'Pedidos')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pedidos</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="search mb-4">
                                    <form action="" class="d-flex justify-content-end">
                                        <input type="search" name="search" placeholder="Pesquisar" class="form-control"
                                               style="width: 250px;" value="{{ request()->search }}">
                                        <button class="btn btn-primary ml-1"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>

                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link {{ (empty(request()->status) ? 'active' : '') }}"
                                           href="{{ route('dashboard.orders.index') }}">Todos
                                            <span
                                                class="badge {{ (empty(request()->status) ? 'badge-white' : 'badge-primary') }}">
                                                {{ $orders->total() }}
                                            </span>
                                        </a>
                                    </li>
                                    @foreach($statues as $status)
                                        <li class="nav-item">
                                            <a class="nav-link {{ ($status->id == request()->status ? 'active' : '') }}"
                                               href="{{ route('dashboard.orders.index', ['status' => $status]) }}">
                                                {{ $status->name }}
                                                <span class="badge
                                                {{ ($status->id == request()->status ? 'badge-white' : 'badge-primary') }}">
                                                    {{ $status->orders_count }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="nav-item">
                                        <a class="nav-link {{ ('error' == request()->status ? 'active' : '') }}"
                                           href="{{ route('dashboard.orders.index', ['status' => 'error']) }}">
                                            Error

                                            <span class="badge
                                            {{ ('error' == request()->status ? 'badge-white' : ($ordersFailCount > 0 ? 'badge-danger' : 'badge-primary')) }}">
                                                {{ $ordersFailCount }}
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if(request()->status == 'error')
                                    <form action="{{ route('dashboard.orders.resend') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-warning mb-3">Reenviar Ordens</button>
                                    </form>
                                @endif
                                <div class="">
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Order ID</th>
                                            <th>Usuário</th>
                                            <th>Detalhes básicos do pedido</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td data-label="ID:">{{ $order->id }}</td>
                                                <td data-label="Order ID:">{{ $order->order_id }}</td>
                                                <td data-label="Usuário:">{{ $order->user->email }}</td>
                                                <td data-label="Detalhes:">
                                                    <div class="title">
                                                        <h6 style="font-size: 0.875rem">{{ $order->service->name }}</h6>
                                                    </div>
                                                    <div>
                                                        <ul class="m-0 pl-0" style="list-style: none">
                                                            <li>Link: {{ $order->link }}</li>
                                                            <li>Valor Gasto: R$ {{ $order->convert_price }} /
                                                                <span class="text-muted">R$ {{ $order->profit }}</span>
                                                            </li>
                                                            <li>Qt. Comprada: {{ $order->quantity }}</li>
                                                            <li>Qt. Inicial: {{ $order->start_count }}</li>
                                                            <li>Qt. Inicial + Comprada:
                                                                {{ $order->quantity + $order->start_count }}
                                                            </li>
                                                            <li>Remains +: {{ $order->remains }}</li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td data-label="Data:">
                                                    {{ $order->convert_date }}<br>
                                                    @if($order->service->refill && $order->status->id == 4)
                                                        <button class="btn btn-sm btn-outline-info mt-2 refill"
                                                                data-toggle="tooltip"
                                                                @if(strtotime($order->refill->completed_at ?? $order->completed_at) > strtotime(date('Y-m-d H:i:s', strtotime("-24 hours"))))
                                                                    disabled
                                                                data-original-title="Refil estará disponível em
                                                                    {{ timeLeft(date('Y-m-d H:i:s', strtotime("-24 hours")), $order->refill->completed_at ?? $order->completed_at) }}"
                                                                @endif
                                                                data-action="{{ route('dashboard.refills.store', ['order' => $order, 'user' => $order->user_id]) }}"
                                                                data-placement="top">
                                                            Refil
                                                        </button>
                                                    @endif
                                                </td>
                                                <td data-label="Status:">
                                                    <div class="badge badge-{{ colorStatusOrder($order->status->id) }}">
                                                        {{ $order->status->name }}
                                                    </div>
                                                </td>
                                                <td data-label="">
                                                    <div class="dropdown d-inline mr-2">
                                                        <button class="btn btn-outline-primary dropdown-toggle"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                            Opção
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @if($order->status_id == 2 && !empty($order->error))
                                                                <a class="dropdown-item" data-url="{{ $order->link }}"
                                                                   href="#" data-toggle="modal"
                                                                   data-details="{{ $order->error }}"
                                                                   data-target="#detailsModal">Detalhes</a>
                                                            @endif
                                                            @if($order->status_id == 2 && !empty($order->error))
                                                                <a class="dropdown-item" data-url="{{ $order->link }}"
                                                                   href="#" data-toggle="modal"
                                                                   data-action="{{ route('dashboard.orders.editLink', ['order' => $order]) }}"
                                                                   data-target="#editLinkModal">Editar Link</a>
                                                            @endif
                                                            @if($order->status_id != 4)
                                                                <a class="dropdown-item" href="#"
                                                                   data-toggle="modal"
                                                                   data-action="{{ route('dashboard.orders.finish', ['order' => $order]) }}"
                                                                   data-target="#finishModal">Concluir</a>
                                                            @endif
                                                            @if($order->status_id != 6 && $order->status_id != 5)
                                                                <a class="dropdown-item" href="#"
                                                                   data-toggle="modal"
                                                                   data-action="{{ route('dashboard.orders.repay', ['order' => $order]) }}"
                                                                   data-target="#repayModal">Reembolsar</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{ $orders->appends(['status' => request()->status, 'search' => request()->search])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="editLinkModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="link">Link</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-link"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" placeholder="Digite seu link" id="link"
                                       name="link">
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="repayModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reembolsar ordem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Voce realmente deseja reembolsar essa ordem?</p>
                    <form method="POST">
                        @csrf
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Reembolsar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="finishModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Completar ordem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Voce realmente deseja Completar essa ordem?</p>
                    <form method="POST">
                        @csrf
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Completar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="detailsModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <pre></pre>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const refill = $('.refill')

        //refill.tooltip('enable')
        refill.click(function () {
            const action = $(this).data('action')
            $(this).attr('disabled', true);

            $.post(action);
        });

        $('#editLinkModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var url = button.data('url') // Extract info from data-* attributes
            var action = button.data('action') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#link').val(url)
            modal.find('form').attr('action', action)
        })

        $('#repayModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var action = button.data('action') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('form').attr('action', action)
        })

        $('#detailsModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var details = button.data('details') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)

            modal.find('pre').html(JSON.stringify(details, null, 2))
        })

        $('#finishModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var action = button.data('action') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('form').attr('action', action)
        })
    </script>
@endpush
