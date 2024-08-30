<?php


namespace App\Support;


class Provider
{
    private $apiUrl;
    private $apiKey;
    private $data;
    private $callback;

    public function __construct(string $url, string $key)
    {
        $this->apiUrl = $url;
        $this->apiKey = $key;
    }

    public function balance(): Provider
    {
        $this->data = [
            'action' => 'balance'
        ];

        $this->post();
        return $this;
    }

    public function serviceList(): Provider
    {
        $this->data = [
            'action' => 'services'
        ];

        $this->post();
        return $this;
    }

    public function addOrder(int $service, string $link, int $quantity = null, string $comments = null): Provider
    {
        $this->data = [
            'action' => 'add',
            'service' => $service,
            'link' => $link,
            'quantity' => $quantity,
            'comments' => $comments
        ];

        $this->post();
        return $this;
    }

    public function statusOrder(int $order): Provider
    {
        $this->data = [
            'action' => 'status',
            'order' => $order,
            'key' => $this->apiKey
        ];

        $this->post();
        return $this;
    }

    public function refill(int $order): Provider
    {
        $this->data = [
            'order' => $order,
            'action' => 'refill',
        ];

        $this->post();
        return $this;
    }

    public function refillStatus(int $refill): Provider
    {
        $this->data = [
            'refill' => $refill,
            'action' => 'refill_status',
        ];

        $this->post();
        return $this;
    }

    private function post()
    {
        $url = $this->apiUrl . "?key=$this->apiKey";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->data));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        $result = curl_exec($ch);

        if (curl_errno($ch) != 0 && empty($result)) {
            $result = false;
        }

        curl_close($ch);
        $this->callback = json_decode($result);

    }

    public function callback()
    {
        return $this->callback;
    }
}
