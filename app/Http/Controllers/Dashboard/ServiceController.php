<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ServiceRequest;
use App\Models\Api;
use App\Models\Category;
use App\Models\Service;
use App\Models\Type;
use App\Support\Provider;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = Category::with('services')->oldest('sort')->paginate(100);
        $apis = Api::latest('id')->get();
        $types = Type::all();

        return view('dashboard.services.index', [
            'categories' => $categories,
            'apis' => $apis,
            'types' => $types
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->all());

        return response()->json([
            'success' => true
        ], 201);
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $service = $service->fill($request->all());
        $service->update();

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->back();
    }


    public function disabled(Service $service)
    {
        $service->status = !$service->status;
        $service->update();

        return redirect()->back();
    }

    public function list(Request $request)
    {
        $api = Api::findOrFail($request->api);

        $provider = new Provider($api->url, $api->token);
        $provider->serviceList();
        $services = $provider->callback();

        return response()->json($services);
    }

    public function import(Request $request)
    {
        $api = Api::findOrFail($request->api);

        $provider = new Provider($api->url, $api->token);
        $provider->serviceList();
        $services = $provider->callback();

        $categories = [];
        foreach ($services as $service) {
            $category = $service->category;
            if (!array_key_exists($category, $categories)) {
                $categories[$category] = [];
            }
            if (in_array($service->service, $request->service_api)) {
                $categories[$category][] = $service;
            }
        }

        $arrayClearEmpty = array_filter($categories, function ($valor) {
            return !is_array($valor) || !empty($valor);
        });

        $sort = 0;
        foreach ($arrayClearEmpty as $index => $services) {
            if (!is_numeric($index)) {
                $category = new Category();
                $category->name = $index;
                $category->sort = $sort;
                $category->save();

                $sort += 1;

                foreach ($services as $service) {
                    $serviceNew = new Service();
                    $serviceNew->category_id = $category->id;
                    $serviceNew->api_id = $api->id;
                    $serviceNew->type_id = 1;
                    $serviceNew->api_service = $service->service;
                    $serviceNew->name = $service->name;
                    $serviceNew->quantity_min = $service->min;
                    $serviceNew->quantity_max = $service->max;
                    $serviceNew->price = $service->rate * ($request->percentage / 100) + $service->rate;
                    $serviceNew->refill = boolval($service->refill);
                    $serviceNew->save();
                }
            }
        }

        return redirect()->back()->withSuccess('Importado com sucesso!');
    }
}
