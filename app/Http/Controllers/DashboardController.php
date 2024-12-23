<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $product = Product::count();
        $transaction = Transaction::count();
        $customer = User::count();
        $totalIncome = DB::table('transactions')
            ->selectRaw('SUM(gross_amount) as total_income')
            ->first();

        $formattedIncome = number_format($totalIncome->total_income, 0, ',', '.');
                
        return view('/admin/dashboard', [
            'title' => 'Dashboard',
            'productCount' => $product,
            'transactionCount' => $transaction,
            'customerCount' => $customer - 1,
            'totalIncome' => $formattedIncome
        ]);
    }

    public function income()
    {
        $incomeData = DB::table('transactions')
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(gross_amount) as total_income')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();
    
        return response()->json(['incomeData' => $incomeData]);
    }
    
}
