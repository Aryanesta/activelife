<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/transaction', [
            'title' => 'Transaction Record',
            'transactions' => Transaction::with('products')->latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // dd($order_id);

        $transaction = Transaction::with('products', 'customer', 'shipping')->findOrFail($id);

        return response()->json([
            'message' => "Berhasil mendapatkan data transaksi",
            'transaction' => $transaction,
        ], 200);

        // return view('/admin/transaction-detail', [
        //     'title' => 'Transaction Detail',
        //     'transaction' => $transaction,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function confirm_transaction(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $transaction = Transaction::findOrFail($transaction_id);
        
        $transaction->process_status = 'process';
        $transaction->save();
        return response()->json([
            'message' => "Transaksi berhasil diverifikasi",
            ], 200);
    }
    public function reject_transaction(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $transaction = Transaction::findOrFail($transaction_id);
        
        $transaction->process_status = 'reject';
        $transaction->save();
        return response()->json([
            'message' => "Transaksi ditolak",
            ], 200);
    }

    public function update_status(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $process_status = $request->input('process_status');
        $transaction = Transaction::findOrFail($transaction_id);

        $transaction->process_status = $process_status;
        $transaction->save();
        return response()->json([
            'message' => "Status transaksi berhasil diubah",
            ], 200);
    }

    public function getTransactionByOrderId(Request $request) {
        $query = $request->input('query-input');
        
        $transactions = Transaction::where('order_id', 'like', '%'.$query.'%')
        ->orWhere('transaction_id', 'like', '%'.$query.'%')
        ->paginate(10);

        return view('admin.transaction', [
            'title' => 'Transaction Record',
            'transactions' => $transactions,
        ]);
    }
}
