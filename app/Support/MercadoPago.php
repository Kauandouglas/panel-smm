<?php

namespace App\Support;

class MercadoPago
{
    private $token;
    private $data;
    private $callback;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function pix(float $price, int $id, string $email, string $name, string $lastName = null): MercadoPago
    {
        $this->data = [
            'transaction_amount' => $price,
            'notification_url' => route('api.payments.notification', [
                'token' => config('api.mercado_pago.token_notification'),
            ]),
            'description' => 'Pagamento ' . $id . ' (' . config('app.name') . ')',
            'payment_method_id' => 'pix',
            'external_reference' => $id,
            'payer' => [
                'email' => $email,
                'first_name' => $name,
                'last_name' => $lastName
            ]
        ];

        $this->post();
        return $this;
    }

    public function post()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->data),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer ' . $this->token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $this->callback = json_decode($response);
    }

    public function callback()
    {
        return $this->callback;
    }
}
