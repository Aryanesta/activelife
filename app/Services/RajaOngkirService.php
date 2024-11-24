<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class RajaOngkirService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.rajaongkir.key');
    }

    public function getProvinces()
    {
        try {
            $response = $this->client->request('GET', 'https://api.rajaongkir.com/starter/province', [
                'headers' => ['key' => $this->apiKey]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['rajaongkir']['results'];
        } catch (\Exception $e) {
            throw new \Exception("Gagal mengambil data provinsi: " . $e->getMessage());
        }
    }

    public function getCities(int $provinceId)
    {
        try {
            $response = $this->client->request('GET', 'https://api.rajaongkir.com/starter/city', [
                'headers' => ['key' => $this->apiKey],
                'query' => ['province' => $provinceId]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['rajaongkir']['results'];
        } catch (\Exception $e) {
            throw new \Exception("Gagal mengambil data kota: " . $e->getMessage());
        }
    }

    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        try {
            $response = $this->client->request('POST', 'https://api.rajaongkir.com/starter/cost', [
                'headers' => ['key' => $this->apiKey],
                'form_params' => [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courier
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['rajaongkir']['results'];
        } catch (\Exception $e) {
            throw new \Exception("Gagal menghitung ongkir: " . $e->getMessage());
        }
    }
}
