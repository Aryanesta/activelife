<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $report = Transaction::all();
        return view('admin.report', [
            'title' => 'Report',
            'report' => $report
        ]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'range-start' => 'required|date',
            'range-end' => 'required|date|after_or_equal:range-start',
        ]);

        $transactions = Transaction::whereBetween('transaction_time', [$request->input('range-start'), $request->input('range-end')])
            ->selectRaw('transaction_id, gross_amount, transaction_status, transaction_time')
            ->get();

        $grand_total_sales = $transactions->sum('gross_amount');
        $total_transactions = $transactions->count();

        return view('admin.report', [
            'title' => 'Report',
            'transactions' => $transactions,
            'grand_total_sales' => $grand_total_sales,
            'total_transactions' => $total_transactions,
            'requestData' => $request->all(),
        ]);
    }
}
