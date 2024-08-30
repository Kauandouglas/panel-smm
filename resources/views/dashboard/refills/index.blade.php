@extends('dashboard.templates.master')
@section('title', 'Refils')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Refils</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link {{ (empty(request()->status) ? 'active' : '') }}"
                                           href="{{ route('dashboard.refills.index') }}">Todos
                                            <span
                                                class="badge {{ (empty(request()->status) ? 'badge-white' : 'badge-primary') }}">
                                                {{ $refills->total() }}
                                            </span>
                                        </a>
                                    </li>
                                    @foreach($statues as $status)
                                        <li class="nav-item">
                                            <a class="nav-link {{ ($status->id == request()->status ? 'active' : '') }}"
                                               href="{{ route('dashboard.refills.index', ['status' => $status]) }}">
                                                {{ $status->name }}
                                                <span class="badge
                                                {{ ($status->id == request()->status ? 'badge-white' : 'badge-primary') }}">
                                                    {{ $status->refills_count }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Refils</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md">
                                        <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>Detalhes básicos do pedido</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                        </tr>
                                        @foreach($refills as $refill)
                                            <tr>
                                                <td>{{ $refill->id }}</td>
                                                <td>
                                                    <div class="title">
                                                        <h6 style="font-size: 0.875rem">{{ $refill->order->service->name }}</h6>
                                                    </div>
                                                    <div>
                                                        <ul class="m-0 pl-0" style="list-style: none">
                                                            <li><b>Order ID:</b> {{ $refill->order->id }}</li>
                                                        </ul>
                                                        <ul class="m-0 pl-0" style="list-style: none">
                                                            <li><b>Link:</b> {{ $refill->order->link }}</li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $refill->convert_date }}<br>
                                                </td>
                                                <td>
                                                    <div class="badge badge-{{ colorStatusOrder($refill->status->id) }}">
                                                        {{ $refill->status->name }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{ $refills->appends(['status' => request()->status])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
