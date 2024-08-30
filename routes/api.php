<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\PaymentController;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api.auth')->group(function () {
    Route::controller(ApiController::class)->group(function () {
        Route::name('api.')->group(function () {
            Route::match(['GET', 'POST'], '/v2', 'index')->name('index');
        });
    });
});

Route::controller(PaymentController::class)->group(function () {
    Route::post('/mercado-pago/notification', 'notification')->name('api.payments.notification');
    Route::post('/stripe/notification', 'notificationStripe')->name('api.payments.notificationStripe');
});

// Send Migrations
Route::post('/sendservices', function (Request $request) {
    $categories = $request->data;

    foreach ($categories as $category) {
        $categoryNew = new \App\Models\Category();
        $categoryNew->id = $category['id'];
        $categoryNew->name = $category['title'];
        $categoryNew->save();

        foreach ($category['services'] as $service) {
            $serviceNew = new \App\Models\Service();
            $serviceNew->id = $service['id'];
            $serviceNew->category_id = $category['id'];
            $serviceNew->api_id = $service['provider_id'];
            $serviceNew->type_id = 1;
            $serviceNew->api_service = $service['provider_service_id'];
            $serviceNew->name = $service['name'];
            $serviceNew->price = $service['rate']['custom'];
            $serviceNew->quantity_min = $service['min']['custom'];
            $serviceNew->quantity_max = $service['max']['custom'];
            $serviceNew->status = $service['status'];
            if (isset($service['options'][0])) {
                $serviceNew->refill = 1;
            }
            $serviceNew->save();
        }
    }
});

// Send Migrations
Route::post('/senduser', function (Request $request) {
    for ($i = 1; $i <= 100; $i++) {
        $url = 'https://eduquei.com/admin/api/users/list?page=' . $i;
        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/113.0',
            'Accept: application/json, text/plain, */*',
            'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
            'Referer: https://eduquei.com/admin/users?page=' . $i,
            'X-Requested-With: XMLHttpRequest',
            'X-KL-kfa-Ajax-Request: Ajax_Request',
            'DNT: 1',
            'Connection: keep-alive',
            'Cookie: PHPSESSID=htchrtio16hb3llnqn57ovvicf; _csrf=83a817e369ae7a55967e7bee4998da5b65a292912077c4f2e658ec40f67781c8a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22ckhZfby1pew9hERqgWcAJwmy9nQh6mOm%22%3B%7D; _csrf_admin=1c65de34879139dbd3ecb2146db093bc7652ad2fd833ff9612024bc967b9a358a%3A2%3A%7Bi%3A0%3Bs%3A11%3A%22_csrf_admin%22%3Bi%3A1%3Bs%3A32%3A%22EGlYKpYGsga0kmOCrKiTgeE9qwy6gSVk%22%3B%7D; admin_hash=ba5bd37e90ad7ef863d8264009f77ac3aace677cf7dadb79007f9f4d2c87fde5a%3A2%3A%7Bi%3A0%3Bs%3A10%3A%22admin_hash%22%3Bi%3A1%3Bs%3A64%3A%2264e37145417cbb327f510cbe8e845551e0170cefd1762282305e997f50f9975f%22%3B%7D',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        // Processar a resposta
        if ($response === false) {
            // Erro na solicitação cURL
            echo 'Erro na solicitação cURL: ' . curl_error($ch);
        } else {
            $users = json_decode($response, true)['data']['users'];
            foreach ($users as $user) {
                if ($user['id'] != 1) {
                    $userSave = \App\Models\User::find($user['id']);
                    if (!$userSave) {
                        $userSave = new \App\Models\User();
                        $userSave->id = $user['id'];
                    }
                    $userSave->username = $user['username'];
                    $userSave->name = $user['username'];
                    $userSave->email = $user['email'];
                    $userSave->balance = $user['balance'];
                    if (isset($user['user_details'][0]['value'])) {
                        $userSave->phone = $user['user_details'][0]['value'];
                    }
                    $userSave->latest_login_at = $user['last_login'];
                    $userSave->created_at = $user['created'];
                    $userSave->updated_at = $user['created'];
                    $userSave->save();
                }
            }
        }
    }
});

// Send Migrations
Route::post('/sendorder', function (Request $request) {
    for ($i = 1; $i <= 1000; $i++) {
        $url = 'https://eduquei.com/admin/api/orders/list?page_size=1000&page=' . $i;
        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/113.0',
            'Accept: application/json, text/plain, */*',
            'Accept-Language: pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3',
            'Referer: https://eduquei.com/admin/users?page=' . $i,
            'X-Requested-With: XMLHttpRequest',
            'X-KL-kfa-Ajax-Request: Ajax_Request',
            'DNT: 1',
            'Connection: keep-alive',
            'Cookie: PHPSESSID=htchrtio16hb3llnqn57ovvicf; _csrf=83a817e369ae7a55967e7bee4998da5b65a292912077c4f2e658ec40f67781c8a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22ckhZfby1pew9hERqgWcAJwmy9nQh6mOm%22%3B%7D; _csrf_admin=1c65de34879139dbd3ecb2146db093bc7652ad2fd833ff9612024bc967b9a358a%3A2%3A%7Bi%3A0%3Bs%3A11%3A%22_csrf_admin%22%3Bi%3A1%3Bs%3A32%3A%22EGlYKpYGsga0kmOCrKiTgeE9qwy6gSVk%22%3B%7D; admin_hash=ba5bd37e90ad7ef863d8264009f77ac3aace677cf7dadb79007f9f4d2c87fde5a%3A2%3A%7Bi%3A0%3Bs%3A10%3A%22admin_hash%22%3Bi%3A1%3Bs%3A64%3A%2264e37145417cbb327f510cbe8e845551e0170cefd1762282305e997f50f9975f%22%3B%7D',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin'
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        // Processar a resposta
        if ($response === false) {
            // Erro na solicitação cURL
            echo 'Erro na solicitação cURL: ' . curl_error($ch);
        } else {
            $sendorders = json_decode($response, true)['data']['orders'];
            foreach ($sendorders as $sendorder) {
                $user = \App\Models\User::where('username', $sendorder['user'])->first();

                if ($user) {
                    $service = Service::where('id', $sendorder['service_id'])->first();
                    $order = \App\Models\Order::find($sendorder['id']);
                    if ($service && !$order) {
                        $newService = new \App\Models\Order();
                        $newService->id = $sendorder['id'];
                        $newService->user_id = $user->id;
                        $newService->service_id = $sendorder['service_id'];
                        if ($sendorder['status'] == '0') {
                            $newService->status_id = 1;
                        } elseif ($sendorder['status'] == '5') {
                            $newService->status_id = 2;
                        } elseif ($sendorder['status'] == '1') {
                            $newService->status_id = 3;
                        } elseif ($sendorder['status'] == '2') {
                            $newService->status_id = 4;
                        } elseif ($sendorder['status'] == '3') {
                            $newService->status_id = 5;
                        } else {
                            $newService->status_id = 6;
                        }

                        $newService->order_id = $sendorder['external_id'];
                        $newService->link = $sendorder['link'];
                        $newService->price = $sendorder['charge'];
                        $newService->quantity = $sendorder['count'];
                        $newService->start_count = $sendorder['start_count'];
                        $newService->remains = $sendorder['remains'];
                        $newService->created_at = $sendorder['created'];
                        $newService->updated_at = $sendorder['created'];
                        $newService->save();
                    }
                }
            }
        }
    }
});
