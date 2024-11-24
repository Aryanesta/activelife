<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
    }

    public function snapToken(Request $request)
    { 
        $order_id = uniqid();
        $items = $request->input('items');
        $amount = $request->input('amount');

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
            'item_details' => $items
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Create New Record
    public function paymentFinish(Request $request) {
        $checkoutData = $request->input('checkoutData');
        $items = json_decode($request->input('items'), true);
        $shippingCost = $request->input('ongkir');

        $address = $request->input('address');
        $courier = $request->input('courier');
        $service = $request->input('service');
        $metadata = $request->input('metadata');
        $snapToken = $request->input('snapToken');
    
        if (is_string($checkoutData)) {
            $checkoutData = json_decode($checkoutData, true);
        }
    
        DB::beginTransaction();
    
        try {
            $shipping = Shipping::create([
                'address' => $address,
                'courier' => $courier,
                'courier_service' => $service,
                'ongkir' => $shippingCost,
            ]);

            $transaction = Transaction::create([
                'customer_id' => Auth::id(),
                'shipping_id' => $shipping->id,
                'transaction_id' => $checkoutData['transaction_id'],
                'order_id' => $checkoutData['order_id'],
                'payment_type' => $checkoutData['payment_type'],
                'gross_amount' => $checkoutData['gross_amount'],
                'transaction_time' => $checkoutData['transaction_time'],
                'transaction_status' => $checkoutData['transaction_status'],
                'metadata' => $metadata,
                'snap_token' => $snapToken,
            ]);
    
            foreach ($items as $item) {
                $transaction->products()->attach($item['id'], ['quantity' => $item['quantity']]);
            }

            DB::commit();
    
            return response()->json(['message' => 'Transaction successfully saved', 'items' => $items]);
    
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Transaction failed', 'message' => $e->getMessage()], 500);
        }
    }
    
}
