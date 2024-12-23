@extends('layouts.dashboard')

@section('container')
<section class="container mt-3 mb-5">
    <!-- Formulir Pilih Periode -->
    <div class="c_periode mb-4 card p-4 mb-5 shadow-sm">
        <h4 class="mb-3">Select Period</h4>
        <form action="{{ route('report.filter') }}" method="post" class="range-period">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label for="range-start" class="form-label">Start Date</label>
                    <input type="date" id="range-start" name="range-start" class="form-control" placeholder="Start Date" required />
                </div>
                <div class="col-md-5">
                    <label for="range-end" class="form-label">End Date</label>
                    <input type="date" id="range-end" name="range-end" class="form-control" placeholder="End Date" required />
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-danger w-100">Generate Report</button>
                </div>
            </div>
        </form>
    </div>

    @isset($transactions)
        @if($transactions->isNotEmpty())
            <!-- Bagian Laporan -->
            <div class="report-section">
                <div class="table-responsive">
                    <table class="table table-bordered mb-4">
                        <thead class="table table-secondary">
                            <tr>
                                <th  class="text-center">Sales Period</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><b>{{ $requestData['range-start'] }}</b> to <b>{{ $requestData['range-end'] }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Gross Amount</th>
                                <th>Status</th>
                                <th>Transaction Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_id }}</td>
                                    <td>Rp{{ number_format($transaction->gross_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $transaction->transaction_status === 'settlement' ? 'success' : ($transaction->transaction_status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($transaction->transaction_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->transaction_time }}</td>
                                </tr>
                            @endforeach
                            <tr class="fw-bold">
                                <td colspan="2" class="text-center">Grand Total Sales</td>
                                <td colspan="2" class="text-center">Rp{{ number_format($grand_total_sales, 2) }}</td>
                            </tr>
                            <tr class="fw-bold">
                                <td colspan="2" class="text-center">Total Transactions</td>
                                <td colspan="2" class="text-center">{{ $total_transactions }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <!-- Pesan Jika Tidak Ada Transaksi -->
            <div class="alert alert-warning text-center py-5">
                <i class="bi bi-exclamation-circle display-3 text-warning"></i>
                <h4 class="mt-3">No transactions found for the selected date range.</h4>
            </div>
        @endif
    @endisset
</section>

@endsection