@extends('layouts.dashboard')

{{-- @dd($transactions[0]->products) --}}

@section('container')

<div class="bg-white shadow card" id="transaction-detail">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5>Detail Transaksi</h5>
    <i class="bi bi-x fs-3" id="transaction-detail-closer"></i>
  </div>
  <div class="card-body" id="transaction-detail-body">
  </div>
  <div class="card-footer p-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
    <span class="fw-bold mb-3 mb-md-0">Transaksi Berlangsung</span>
    <select class="form-select w-100 w-md-auto" id="transaction-detail-print">
      <option value="pending">Menunggu Konfirmasi</option>
      <option value="processing">Diproses</option>
      <option value="shipping">Dikirim</option>
    </select>
  </div>  
</div>

<div class="container">
    <table class="table table-hover">
        <thead>
            <tr>
              <th scope="col">Order Id</th>
              <th scope="col">Gross Amount</th>
              <th scope="col">Address</th>
              <th scope="col">Courier</th>
              <th scope="col">Service</th>
              <th scope="col">Time</th>
              {{-- <th scope="col">Metadata</th> --}}
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($transactions as $transaction)
            <tr>
              <td>{{ $transaction->order_id }}</td>
              <td>Rp{{ number_format($transaction->gross_amount) }}</td>
              <td>{{ $transaction->shipping->address }}</td>
              <td>{{ $transaction->shipping->courier }}</td>
              <td>{{ $transaction->shipping->courier_service }}</td>
              <td>{{ $transaction->transaction_time }}</td>
              {{-- <td>{{ $transaction->metadata }}</td> --}}
              <td>{{ $transaction->transaction_status }}</td>
              <td>
                {{-- <a href="{{ route('transaction.show', $transaction->id) }}" class="bi bi-eye btn btn-danger"> --}}
                  <button class="bi bi-eye btn btn-danger transaction-detail-trigger" id="transaction-detail-trigger-{{ $transaction->id }}" data-transaction-id="{{ $transaction->id }}"></button>
              </td>
            </tr>
            <script src="{{ asset('js/transaction.js') }}"></script>
            @endforeach
          </tbody>
    </table>
</div>
@endsection