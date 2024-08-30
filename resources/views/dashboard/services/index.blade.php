@extends('dashboard.templates.master')
@section('title', 'Serviços')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Serviços</h1>
            </div>

            <div class="section-body category">
                <button class="btn btn-outline-primary mb-3" data-toggle="modal" data-target="#serviceModal">
                    Cadastrar Serviço
                </button>
                <button class="btn btn-primary mb-3 ml-2" data-toggle="modal" data-target="#categoryModal">
                    Cadastrar Categoria
                </button>
                <button class="btn btn-outline-danger mb-3 ml-2" data-toggle="modal" data-target="#importServiceModal">
                    Importar Serviços
                </button>

                @foreach($categories as $category)
                    <table class="table table-bordered shadow" id="categories_{{ $category->id }}">
                        <thead>
                        <tr>
                            <th scope="col" colspan="7">
                                <span style="{{ (!$category->status ? 'opacity: 0.3' : '') }}">
                                    {{ $category->name }}
                                </span>
                                <button class="btn btn-danger btn-sm float-right ml-1" data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-action="{{ route('dashboard.categories.destroy', ['category' => $category]) }}">
                                    Apagar
                                </button>
                                @if($category->status)
                                    <button class="btn btn-danger btn-sm float-right" data-toggle="modal"
                                            data-target="#disableModal"
                                            data-action="{{ route('dashboard.categories.disabled', ['category' => $category]) }}">
                                        Desativar
                                    </button>
                                @else
                                    <button class="btn btn-success btn-sm float-right" data-toggle="modal"
                                            data-target="#disableModal"
                                            data-action="{{ route('dashboard.categories.disabled', ['category' => $category]) }}">
                                        Ativar
                                    </button>
                                @endif
                            </th>
                        </tr>
                        <tr style="{{ (!$category->status ? 'opacity: 0.3' : '') }}">
                            <th scope="col" class="bg-white">#</th>
                            <th scope="col" class="bg-white">Nome</th>
                            <th scope="col" class="bg-white">Preço por cada 1000(R$)</th>
                            <th scope="col" class="bg-white">Min / Max por Pedido</th>
                            <th scope="col" class="bg-white">Status</th>
                            <th scope="col" class="bg-white">Descrição</th>
                            <th scope="col" class="bg-white">Opcões</th>
                        </tr>
                        </thead>
                        <tbody style="{{ (!$category->status ? 'opacity: 0.3' : '') }}">
                        @foreach($category->services as $service)
                            <tr style="{{ (!$service->status ? 'opacity: 0.3' : '') }}">
                                <th scope="row">{{ $service->id }}</th>
                                <th>{{ $service->name }}</th>
                                <th>{{ $service->price }}</th>
                                <th>{{ $service->quantity_min }} / {{ $service->quantity_max }}</th>
                                <th>
                                    @if($service->status)
                                        <button class="btn btn-danger float-right" data-toggle="modal"
                                                data-target="#disableModal"
                                                data-action="{{ route('dashboard.services.disabled', ['service' => $service]) }}">
                                            Desativar
                                        </button>
                                    @else
                                        <button class="btn btn-success float-right" data-toggle="modal"
                                                data-target="#disableModal"
                                                data-action="{{ route('dashboard.services.disabled', ['service' => $service]) }}">
                                            Ativar
                                        </button>
                                    @endif
                                </th>
                                <th>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#descriptionModal"
                                            data-description="{{ nl2br($service->description) }}"
                                            data-title="{{ $service->name }}">
                                        Detalhes
                                    </button>
                                </th>
                                <th>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#serviceModal"
                                            data-edit="true" data-category-id="{{ $category->id }}"
                                            data-api-id="{{ $service->api_id }}" data-type-id="{{ $service->type_id }}"
                                            data-service-id="{{ $service->api_service }}"
                                            data-name="{{ $service->name }}"
                                            data-description="{{ $service->description }}"
                                            data-min="{{ $service->quantity_min }}"
                                            data-max="{{ $service->quantity_max }}" data-price="{{ $service->price }}"
                                            data-refill="{{ $service->refill }}"
                                            data-action="{{ route('dashboard.services.update', ['service' => $service]) }}">
                                        Editar
                                    </button>
                                    <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-action="{{ route('dashboard.services.destroy', ['service' => $service]) }}">
                                        Apagar
                                    </button>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endforeach

                {{ $categories->links() }}
            </div>
        </section>
    </div>

    <div class="modal fade" id="importServiceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Importar serviços</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('dashboard.services.import', ['api' => $apis[0]['id']]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="percentage">Porcentagem do valor %</label>
                                    <div class="input-group">
                                        <input type="number" name="percentage" id="percentage" class="form-control"
                                               value="30" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Importar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </form>
                </div>
            </div>
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

    <div class="modal fade" id="disableModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Desativar categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        Você realmente deseja desativar essa categoria?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Desativar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remover categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Você realmente deseja remover essa categoria?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Remover</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Category --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="categoryModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dashboard.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" placeholder="Digite o nome" id="name"
                                       name="name">
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Service --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="serviceModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo serviço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="messageError" class="alert alert-danger mt-4 d-none"></div>

                    <form action="" method="POST" id="formOrder">
                        @csrf
                        <div class="form-group">
                            <label for="category">Categoria</label>
                            <div class="input-group">
                                <select name="category_id" id="category" class="form-control">
                                    @foreach($categories as $category)
                                        @if($category->status == 1)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api">Api</label>
                            <div class="input-group">
                                <select name="api_id" id="api" class="form-control">
                                    @foreach($apis as $api)
                                        <option value="{{ $api->id }}">{{ $api->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">Tipo</label>
                            <div class="input-group">
                                <select name="type_id" id="type" class="form-control">
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="api_service">Serviços</label>
                            <div class="input-group">
                                <select name="api_service" id="api_service" class="form-control"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <div class="input-group">
                                <input name="name" id="name" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Descricão</label>
                            <div class="input-group">
                                <textarea name="description" id="description" cols="30" rows="10"
                                          class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity_min">Quantidade minina</label>
                            <div class="input-group">
                                <input type="number" id="quantity_min" name="quantity_min" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="quantity_max">Quantidade maxima</label>
                            <div class="input-group">
                                <input type="number" id="quantity_max" name="quantity_max" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">Preço</label>
                            <div class="input-group">
                                <input type="text" id="price" name="price" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="refill" name="refill" value="1">
                                <label class="custom-control-label" for="refill">Refill</label>
                            </div>

                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="spinner-border spinner-border-sm mr-1 d-none"
                                      role="status" aria-hidden="true"></span>
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#importServiceModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)

            modal.find('tbody').html('')
            $.get('{{ route('dashboard.services.list') }}', {'api': '{{ $apis[0]['id'] }}'}, function (response) {
                $.each(response, function (index, value) {
                    modal.find('tbody').append(`<tr>
                        <th scope="row">
                           <input type="checkbox" name="service_api[]" value="` + value.service + `"
                                id="serviceApi">
                        </th>
                        <td>` + value.service + `</td>
                        <td>` + value.name + `</td>
                    </tr>`)
                })
            }, 'json')
        })

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

        $('#disableModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var action = button.data('action') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('form').attr('action', action)
        })

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var action = button.data('action') // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('form').attr('action', action)
        })

        $('#api').change(function () {
            api()
        })

        function api(service = undefined) {
            $('#api_service').html('<option value="">Selecione o serviço</option>')
            $.get('{{ route('dashboard.services.list') }}', {'api': $('#api').val()}, function (response) {
                $.each(response, function (index, value) {
                    $('#api_service').append('<option ' + ((service == value.service) ? 'selected' : '') +
                        ' data-min="' + value.min + '" data-max="' + value.max + '" ' +
                        'data-refill="' + value.refill + '" value="' + value.service + '">' +
                        value.service + ' - ' + value.name + '</option>')
                })
            }, 'json')
        }

        $('#serviceModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var edit = button.data('edit') // Extract info from data-* attributes
            var category = button.data('category-id') // Extract info from data-* attributes
            var api_id = button.data('api-id') // Extract info from data-* attributes
            var type = button.data('type-id') // Extract info from data-* attributes
            var service = button.data('service-id') // Extract info from data-* attributes
            var name = button.data('name') // Extract info from data-* attributes
            var description = button.data('description') // Extract info from data-* attributes
            var min = button.data('min') // Extract info from data-* attributes
            var max = button.data('max') // Extract info from data-* attributes
            var price = button.data('price') // Extract info from data-* attributes
            var refill = button.data('refill') // Extract info from data-* attributes
            var action = button.data('action') // Extract info from data-* attributes

            var modal = $(this)

            if (edit == true) {
                modal.find('.modal-title').text('Editar serviço')
                modal.find('#category').val(category)
                modal.find('#api').val(api_id)
                modal.find('#type').val(type)
                modal.find('#name').val(name)
                modal.find('#description').val(description)
                modal.find('#quantity_min').val(min)
                modal.find('#quantity_max').val(max)
                modal.find('#price').val(price)

                if (refill) {
                    $('#refill').prop('checked', true)
                } else {
                    $('#refill').prop('checked', false)
                }

                $('#formOrder').attr('action', action)
                $('#formOrder').append('@method('PUT')')
            } else {
                modal.find('.modal-title').text('Novo serviço')
                $('#formOrder').attr('action', "{{ route('dashboard.services.store') }}")
                $('#formOrder').find('input[name="_method"]').remove()
            }

            api(service)
        })

        // Add Data
        $('#api_service').change(function () {
            var min = $(this).find(':selected').data('min')
            var max = $(this).find(':selected').data('max')
            var refill = $(this).find(':selected').data('refill')

            if (refill) {
                $('#refill').prop('checked', true)
            } else {
                $('#refill').prop('checked', false)
            }

            $('#quantity_min').val(min)
            $('#quantity_max').val(max)
        })

        // Submit form
        jQuery(document).ready(function () {
            jQuery('#formOrder').submit(function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var form = $(this);

                jQuery.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: data,
                    dataType: "json",
                    beforeSend: function (response) {
                        form.find('button').attr('disabled', true);
                        form.find('.spinner-border').removeClass('d-none')
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (response) {
                        var message = '';
                        $.each(response.responseJSON.errors, function (index, value) {
                            message += value + '<br>';
                        });

                        $('#messageError').removeClass('d-none').html(message)
                    },
                    complete: function (response) {
                        form.find('button').attr('disabled', false);
                        form.find('.spinner-border').addClass('d-none')
                    }
                });

                return false;
            });
        });

        $(".category").sortable({
            update: function () {
                var categories = $(this).sortable("serialize");
                $.post("{{ route('dashboard.categories.sort') }}", categories)
            }
        });
    </script>
@endpush
