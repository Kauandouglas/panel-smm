@extends('panel.templates.master')
@section('title', 'Novo Pedido')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Novo Pedido</h1>
            </div>
            <div class="section-body">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="api">
                            <div class="center-big-content-block">
                                <div class="center-big-content-block">
                                    <table class="table api table-bordered">
                                        <tbody>
                                        <tr>
                                            <td class="width-40">HTTP Method</td>
                                            <td>POST</td>
                                        </tr>
                                        <tr>
                                            <td>API URL</td>
                                            <td>{{ route('api.index') }}</td>
                                        </tr>
                                        <tr>
                                            <td>API Key</td>
                                            <td>{{ Auth::user()->api_key }}</td>
                                        </tr>
                                        <tr>
                                            <td>Response format</td>
                                            <td>JSON</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h4 class="m-t-md"><strong>Service list</strong></h4>
                                    <table class="table api table-bordered">
                                        <thead class="api-thead">
                                        <tr>
                                            <th class="width-40">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>key</td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td>action</td>
                                            <td>services</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p><strong>Example response</strong></p>
                                    <pre class="code">[
    {
        "service": 1,
        "name": "Followers",
        "type": "Default",
        "category": "First Category",
        "rate": "0.90",
        "min": "50",
        "max": "10000",
        "refill": true
    },
    {
        "service": 2,
        "name": "Comments",
        "type": "Custom Comments",
        "category": "Second Category",
        "rate": "8",
        "min": "10",
        "max": "1500",
        "refill": false
    }
]
</pre>
                                    <h4 class="m-t-md"><strong>Add order</strong></h4>
                                    <p>
                                    </p>
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <select class="form-control input-sm" id="service_type">
                                                <option value="0">Default</option>
                                                <option value="1">Custom Comments</option>
                                            </select>
                                        </div>
                                    </form>
                                    <p></p>
                                    <div id="type_0" style="">
                                        <table class="table api table-bordered">
                                            <thead class="api-thead">
                                            <tr>
                                                <th class="width-40">Parameters</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>key</td>
                                                <td>Your API key</td>
                                            </tr>
                                            <tr>
                                                <td>action</td>
                                                <td>add</td>
                                            </tr>
                                            <tr>
                                                <td>service</td>
                                                <td>Service ID</td>
                                            </tr>
                                            <tr>
                                                <td>link</td>
                                                <td>Link to page</td>
                                            </tr>
                                            <tr>
                                                <td>quantity</td>
                                                <td>Needed quantity</td>
                                            </tr>
                                            <tr>
                                                <td>runs (optional)</td>
                                                <td>Runs to deliver</td>
                                            </tr>
                                            <tr>
                                                <td>interval (optional)</td>
                                                <td>Interval in minutes</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="type_10" style="display:none;">
                                        <table class="table api table-bordered">
                                            <thead class="api-thead">
                                            <tr>
                                                <th class="width-40">Parameters</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>key</td>
                                                <td>Your API key</td>
                                            </tr>
                                            <tr>
                                                <td>action</td>
                                                <td>add</td>
                                            </tr>
                                            <tr>
                                                <td>service</td>
                                                <td>Service ID</td>
                                            </tr>
                                            <tr>
                                                <td>link</td>
                                                <td>Link to page</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="type_2" style="display:none;">
                                        <table class="table api table-bordered">
                                            <thead class="api-thead">
                                            <tr>
                                                <th class="width-40">Parameters</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>key</td>
                                                <td>Your API key</td>
                                            </tr>
                                            <tr>
                                                <td>action</td>
                                                <td>add</td>
                                            </tr>
                                            <tr>
                                                <td>service</td>
                                                <td>Service ID</td>
                                            </tr>
                                            <tr>
                                                <td>link</td>
                                                <td>Link to page</td>
                                            </tr>
                                            <tr>
                                                <td>comments</td>
                                                <td>Comments list separated by \r\n or \n</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="type_100" style="display:none;">
                                        <table class="table api table-bordered">
                                            <thead class="api-thead">
                                            <tr>
                                                <th class="width-40">Parameters</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>key</td>
                                                <td>Your API key</td>
                                            </tr>
                                            <tr>
                                                <td>action</td>
                                                <td>add</td>
                                            </tr>
                                            <tr>
                                                <td>service</td>
                                                <td>Service ID</td>
                                            </tr>
                                            <tr>
                                                <td>username</td>
                                                <td>Username</td>
                                            </tr>
                                            <tr>
                                                <td>min</td>
                                                <td>Quantity min</td>
                                            </tr>
                                            <tr>
                                                <td>max</td>
                                                <td>Quantity max</td>
                                            </tr>
                                            <tr>
                                                <td>posts</td>
                                                <td>New posts count</td>
                                            </tr>
                                            <tr>
                                                <td>delay</td>
                                                <td>Delay in minutes. Possible values: 0, 5, 10, 15, 30, 60, 90</td>
                                            </tr>
                                            <tr>
                                                <td>expiry (optional)</td>
                                                <td>Expiry date. Format d/m/Y</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="type_17" style="display:none;">
                                        <table class="table api table-bordered">
                                            <thead class="api-thead">
                                            <tr>
                                                <th class="width-40">Parameters</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>key</td>
                                                <td>Your API key</td>
                                            </tr>
                                            <tr>
                                                <td>action</td>
                                                <td>add</td>
                                            </tr>
                                            <tr>
                                                <td>service</td>
                                                <td>Service ID</td>
                                            </tr>
                                            <tr>
                                                <td>link</td>
                                                <td>Link to page</td>
                                            </tr>
                                            <tr>
                                                <td>quantity</td>
                                                <td>Needed quantity</td>
                                            </tr>
                                            <tr>
                                                <td>answer_number</td>
                                                <td>Answer number of the poll</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p><strong>Example response</strong></p>
                                    <pre class="code">{
    "order": 23501
}
</pre>
                                    <h4 class="m-t-md"><strong>Order status</strong></h4>
                                    <table class="table api table-bordered">
                                        <thead class="api-thead">
                                        <tr>
                                            <th class="width-40">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>key</td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td>action</td>
                                            <td>status</td>
                                        </tr>
                                        <tr>
                                            <td>order</td>
                                            <td>Order ID</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p><strong>Example response</strong></p>
                                    <pre class="code">{
    "charge": "0.27819",
    "start_count": "3572",
    "status": "Partial",
    "remains": "157",
    "currency": "USD"
}
</pre>
                                    <h4 class="m-t-md"><strong>Multiple orders status</strong></h4>
                                    <table class="table api table-bordered">
                                        <thead class="api-thead">
                                        <tr>
                                            <th class="width-40">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>key</td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td>action</td>
                                            <td>status</td>
                                        </tr>
                                        <tr>
                                            <td>orders</td>
                                            <td>Order IDs separated by comma</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p><strong>Example response</strong></p>
                                    <pre class="code">{
    "1": {
        "charge": "0.27819",
        "start_count": "3572",
        "status": "Partial",
        "remains": "157",
        "currency": "USD"
    },
    "10": {
        "error": "Incorrect order ID"
    },
    "100": {
        "charge": "1.44219",
        "start_count": "234",
        "status": "In progress",
        "remains": "10",
        "currency": "USD"
    }
}
</pre>
                                    <h4 class="m-t-md"><strong>Create refill</strong></h4>
                                    <table class="table api table-bordered">
                                        <thead class="api-thead">
                                        <tr>
                                            <th class="width-40">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>key</td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td>action</td>
                                            <td>refill</td>
                                        </tr>
                                        <tr>
                                            <td>order</td>
                                            <td>Order ID</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p><strong>Example response</strong></p>
                                    <pre class="code">{
    "refill": "1"
}
</pre>
                                    <h4 class="m-t-md"><strong>Get refill status</strong></h4>
                                    <table class="table api table-bordered">
                                        <thead class="api-thead">
                                        <tr>
                                            <th class="width-40">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>key</td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td>action</td>
                                            <td>refill_status</td>
                                        </tr>
                                        <tr>
                                            <td>refill</td>
                                            <td>Refill ID</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p><strong>Example response</strong></p>
                                    <pre class="code">{
    "status": "Completed"
}
</pre>
                                    <h4 class="m-t-md"><strong>User balance</strong></h4>
                                    <table class="table api table-bordered">
                                        <thead class="api-thead">
                                        <tr>
                                            <th class="width-40">Parameters</th>
                                            <th>Description</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>key</td>
                                            <td>Your API key</td>
                                        </tr>
                                        <tr>
                                            <td>action</td>
                                            <td>balance</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <p><strong>Example response</strong></p>
                                    <pre class="code">{
    "balance": "100.84292",
    "currency": "USD"
}
</pre>
                                    <a href="/example.txt" class="btn btn-primary m-t" style="line-height: 50px"
                                       target="_blank">Example of PHP code</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
