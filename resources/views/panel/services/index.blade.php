@extends('panel.templates.master')
@section('title', 'Serviços')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Serviços</h1>
            </div>

            <div class="section-body">
                <div class="">
                    @foreach($categories as $category)
                        <table class="table table-bordered shadow">
                            <thead>
                            <tr>
                                <th scope="col" class="d-table-cell" colspan="5">{{ $category->name }}</th>
                            </tr>
                            <tr>
                                <th scope="col" class="bg-white">#</th>
                                <th scope="col" class="bg-white">Nome</th>
                                <th scope="col" class="bg-white">Preço por cada 1000(R$)</th>
                                <th scope="col" class="bg-white">Min / Max por Pedido</th>
                                <th scope="col" class="bg-white">Descrição</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($category->services as $service)
                                <tr>
                                    <td data-label="ID: ">{{ $service->id }}</td>
                                    <td data-label="Nome: ">{{ $service->name }}</td>
                                    <td data-label="Preço: ">R$ {{ number_format($service->userServicePrice->price ?? $service->price, 2, ',', '.') }}</td>
                                    <td data-label="Min / Max: ">{{ $service->quantity_min }} / {{ $service->quantity_max }}</td>
                                    <td>
                                        <button class="btn btn-primary" data-toggle="modal"
                                                data-target="#descriptionModal"
                                                data-description="{{ nl2br($service->description) }}"
                                                data-title="{{ $service->name }}">
                                            Detalhes
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>

                {{ $categories->links() }}
            </div>
        </section>
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
