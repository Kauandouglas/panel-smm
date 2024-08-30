@extends('dashboard.templates.master')
@section('title', 'Relatório de Pagamentos')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Relatório de Pagamentos</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.reports.order') }}">Ordens</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('dashboard.reports.payment') }}">Pagamentos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.reports.ticket') }}">Tickets</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.reports.profit') }}">Lucros</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th></th> <!-- Empty cell in the top-left corner -->
                                            @foreach ($paymentTable as $month => $i)
                                                <th>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($days as $day)
                                            <tr>
                                                <td><b>{{ $day }}</b></td>
                                                @foreach ($paymentTable as $month)
                                                    <td class="text-center">{{ number_format($month[$day], 2) }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><b>Total</b></td>
                                            @foreach ($paymentTable as $month)
                                                <td class="text-center"><b>R$ {{ array_sum($month) }}</b></td>
                                            @endforeach
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
