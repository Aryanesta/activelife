<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Transaction $invoice) {
        return view('invoice', [
            'title' => 'Invoice',
            'invoice' => $invoice::with('shipping', 'customer', 'products')->where('order_id', $invoice->order_id)->first()
        ]);
    }
}
