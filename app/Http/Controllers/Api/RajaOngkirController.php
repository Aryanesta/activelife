<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\RajaOngkirService;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class RajaOngkirController extends Controller
{
    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    public function index()
    {
        return view('admin/checkout', [
            'title' => 'Checkout'
        ]);
    }

    public function getProvince()
    {
        try {
            $data = $this->rajaOngkirService->getProvinces();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Data gagal diambil!",
                "error" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getCity(int $provinceId)
    {
        try {
            $data = $this->rajaOngkirService->getCities($provinceId);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Data gagal diambil!",
                "error" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getOngkir(Request $request)
    {
        // dd($request);
        try {
            $origin = $request->input('origin');
            $destination = $request->input('destination');
            $weight = $request->input('weight');
            $courier = $request->input('courier');

            $data = $this->rajaOngkirService->getShippingCost($origin, $destination, $weight, $courier);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Data gagal dihitung!",
                "error" => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
