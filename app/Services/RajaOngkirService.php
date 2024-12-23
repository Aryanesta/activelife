<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
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
            return Cache::remember('provinces', 60, function () {
                $response = $this->client->request('GET', 'https://api.rajaongkir.com/starter/province', [
                    'headers' => ['key' => $this->apiKey]
                ]);
    
                $data = json_decode($response->getBody()->getContents(), true);
                return $data['rajaongkir']['results'];
            });
        } catch (\Exception $e) {
            throw new \Exception("Gagal mengambil data provinsi: " . $e->getMessage());
        }
    }
    

    public function getCities(int $provinceId)
    {
        try {
            return Cache::remember("cities_province_{$provinceId}", 60, function () use ($provinceId) {
                $response = $this->client->request('GET', 'https://api.rajaongkir.com/starter/city', [
                    'headers' => ['key' => $this->apiKey],
                    'query' => ['province' => $provinceId]
                ]);
    
                $data = json_decode($response->getBody()->getContents(), true);
                return $data['rajaongkir']['results'];
            });
        } catch (\Exception $e) {
            throw new \Exception("Gagal mengambil data kota: " . $e->getMessage());
        }
    }
    

    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        try {
            $cacheKey = "shipping_cost_{$origin}_{$destination}_{$weight}_{$courier}";
    
            return Cache::remember($cacheKey, 60, function () use ($origin, $destination, $weight, $courier) {
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
            });
        } catch (\Exception $e) {
            throw new \Exception("Gagal menghitung ongkir: " . $e->getMessage());
        }
    }
    

}
