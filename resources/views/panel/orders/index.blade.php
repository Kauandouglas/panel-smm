@extends('panel.templates.master')
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
                                <div class="row">
                                    <div class="col-lg-9">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item">
                                                <a class="nav-link {{ (empty(request()->status) ? 'active' : '') }}"
                                                   href="{{ route('panel.orders.index') }}">Todos
                                                    <span
                                                        class="badge {{ (empty(request()->status) ? 'badge-white' : 'badge-primary') }}">
                                                        {{ $orders->total() }}
                                                    </span>
                                                </a>
                                            </li>
                                            @foreach($statues as $status)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ ($status->id == request()->status ? 'active' : '') }}"
                                                       href="{{ route('panel.orders.index', ['status' => $status]) }}">
                                                        {{ $status->name }}
                                                        <span class="badge
                                                        {{ ($status->id == request()->status ? 'badge-white' : 'badge-primary') }}">
                                                            {{ $status->orders_count }}
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-lg-3">
                                        <form action="">
                                            <input type="text" class="form-control" id="basic-url"
                                                   value="{{ request()->search }}" placeholder="Pesquisar Ordem"
                                                   name="search">
                                            <button class="btn"
                                                    style="position: absolute;right: 13px;top: 0px;text-align: center;width: 40px;height: 40px;line-height: 33px;">
                                                <i class="fas fa-search"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>
                                    <a class="text-decoration-none" href="{{ route('panel.orders.create') }}">
                                        <span class="add-new">
                                            <i class="fa fa-plus-square text-primary" aria-hidden="true"></i>
                                        </span>
                                    </a> Novo Pedido</h4>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Detalhes básicos do pedido</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td data-label="ID: ">{{ $order->id }}</td>
                                                <td data-label="Detalhes: ">
                                                    <div class="title">
                                                        <h6 style="font-size: 0.875rem">{{ $order->service->name }}</h6>
                                                    </div>
                                                    <div>
                                                        <ul class="m-0 pl-0" style="list-style: none">
                                                            <li>Link: {{ $order->link }}</li>
                                                            <li>Valor Gasto: R$ {{ $order->convert_price }}</li>
                                                            <li>Qt. Comprada: {{ $order->quantity }}</li>
                                                            <li>Qt. Inicial: {{ $order->start_count }}</li>
                                                            <li>Qt. Inicial + Comprada:
                                                                {{ $order->quantity + $order->start_count }}
                                                            </li>
                                                            <li>Remains +: {{ $order->remains }}</li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td data-label="Data: ">
                                                    {{ $order->convert_date }}<br>
                                                    @if($order->service->refill && $order->status->id == 4)
                                                        <button class="btn btn-sm btn-outline-info mt-2 refill"
                                                                data-toggle="tooltip"
                                                                @if(strtotime($order->refill->completed_at ?? $order->completed_at) > strtotime(date('Y-m-d H:i:s', strtotime("-24 hours"))))
                                                                    disabled
                                                                data-original-title="Refil estará disponível em
                                                                    {{ timeLeft(date('Y-m-d H:i:s', strtotime("-24 hours")), $order->refill->completed_at ?? $order->completed_at) }}"
                                                                @endif
                                                                data-action="{{ route('panel.refills.store', ['order' => $order]) }}"
                                                                data-placement="top">
                                                            Refil
                                                        </button>
                                                    @endif
                                                </td>
                                                <td data-label="Status: ">
                                                    <div class="badge badge-{{ colorStatusOrder($order->status->id) }}">
                                                        {{ $order->status->name }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{ $orders->appends(['status' => request()->status, 'order' => request()->order])->links() }}
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
        const refill = $('.refill')

        refill.tooltip('enable')
        refill.click(function () {
            const action = $(this).data('action')
            $(this).attr('disabled', true);

            $.post(action);
        });
    </script>
@endpush
