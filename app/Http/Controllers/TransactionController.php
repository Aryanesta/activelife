<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
    }

    public function index() {
        $transactions = Transaction::where('customer_id', Auth::user()->id)->latest()->paginate(10);
        return view('transaction-history', [
            'title' => 'Transaction history',
            'transactions' => $transactions
        ]);
    }

    public function snapToken(Request $request)
    { 
        // return response()->json(['data' => $request->input('items')]);

        $order_id = uniqid();
        $items = $request->input('items');
        
        $ongkir = array_shift($items); 
        $amount = $request->input('amount');
        
        foreach ($items as $item) {
            $product = Product::find($item['id']);
            
            if (!$product || $product->stock < $item['quantity']) {
                return response()->json([
                    'error' => "Insufficient stock for product name: {$item['name']}, current stock: {$product->stock}"
                ], 400);
            }
    
            $product->update(['stock' => $product->stock - $item['quantity']]);
        }
        
        $totalAmount = $amount + $ongkir['price'];
    
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $totalAmount, 
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
            'item_details' => array_merge($items, [
                [
                    'id' => 'ongkir', 
                    'price' => $ongkir['price'], 
                    'quantity' => 1, 
                    'name' => 'Ongkir'
                ]
            ]),
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

    // public function paymentUpdate(Request $request, Transaction $transaction) {
    //     $checkoutData = $request->input('checkoutData');

    //     if (is_string($checkoutData)) {
    //         $checkoutData = json_decode($checkoutData, true);
    //     }
    
    //     try {
    //         $transaction->transaction_status = $checkoutData['transaction_status'];
    //         $transaction->save();
            
    //         return response()->json([
    //             'message' => 'Transaction successfully saved',
    //             'transaction' => $transaction,
    //         ]);
            
    
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'Transaction failed',
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }

    // }

    public function paymentUpdate(Request $request)
    {
        // return response()->json($request);

        // Buat test browser
        $checkoutData = $request->input('checkoutData');
        $data = json_decode($checkoutData, true);

        // Buat test postman
        // $data = $request->input('checkoutData');

        // $serverKey = config('midtrans.server_key');
        // $signatureKey = hash('sha512', $data['order_id'] . $data['status_code'] . $data['gross_amount'] . $serverKey);
    
        // if ($signatureKey !== $data['signature_key']) {
        //     return response()->json(['message' => 'Invalid Signature'], 403);
        // }
    
        try {
            $transaction = Transaction::find($request->input('id'));
            
            // return response()->json($transaction->transaction_status);

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            if ($data['status_code']) {
                if ($data['status_code'] === 407) {
    
                    $transaction->transaction_status = 'expire';
                    $transaction->save();

                    return response()->json(['message' => 'Notification processed successfully', 'transaction' => $transaction], 200);;
                }
            }

            $transaction->transaction_status = $data['transaction_status'];

            $transaction->save();
    
            return response()->json(['message' => 'Notification processed successfully', 'transaction' => $transaction], 200);
    
        } catch (\Exception $e) {
            Log::error('Error processing Midtrans notification: ' . $e->getMessage());
    
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    
}
