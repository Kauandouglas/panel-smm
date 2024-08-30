<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ApiRequest;
use App\Models\Api;
use App\Support\Provider;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $apis = Api::latest('id')->paginate(15);

        return view('dashboard.apis.index', [
            'apis' => $apis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ApiRequest $request)
    {
        $provider = new Provider($request->url, $request->token);
        $provider->balance();
        $providerCallback = $provider->callback();

        if (!isset($providerCallback->balance)) {
            return redirect()->back()->withErrors('Parece haver um problema de conexão com o provedor de API.');
        }

        $request['balance'] = $providerCallback->balance;
        $request['coin'] = $providerCallback->currency;
        $api = Api::create($request->all());

        return redirect()->back()->withSuccess('Cadastrado com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Api $api
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApiRequest $request, Api $api)
    {
        $provider = new Provider($request->url, $request->token);
        $provider->balance();
        $providerCallback = $provider->callback();

        if (!isset($providerCallback->balance)) {
            return redirect()->back()->withErrors('Parece haver um problema de conexão com o provedor de API.');
        }

        $request['balance'] = $providerCallback->balance;
        $request['coin'] = $providerCallback->currency;
        $api = $api->fill($request->all());
        $api->update();

        return redirect()->back()->withSuccess('Editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Api $api
     * @return \Illuminate\Http\Response
     */
    public function destroy(Api $api)
    {
        $api->delete();

        return redirect()->back()->withSuccess('Apagado com sucesso!');
    }
}
