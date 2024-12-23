@extends('layouts.dashboard')

{{-- @dd($transactions[0]->products) --}}

@section('container')

<div class="row align-items-center mb-4">
  <!-- Search Bar -->
  <div class="col-md-6 mb-3 mb-md-0">
    <form action="{{ route('searchTransaction') }}" method="POST" class="input-group">
      <input 
        type="text" 
        class="form-control" 
        placeholder="Search transactions..." 
        id="product-search-input"
        name="query-input"
      >
      @csrf
      <button 
        class="btn btn-danger" 
        id="product-search-btn"
      >
        Search
      </button>
    </form>
  </div>
</div>


<div class="bg-white shadow card" id="transaction-detail">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5>Detail Transaksi</h5>
    <i class="bi bi-x fs-3" id="transaction-detail-closer"></i>
  </div>
  <div class="card-body" id="transaction-detail-body">
  </div>
  <div class="card-footer p-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
  </div>
</div>

@isset($transactions)
  @if($transactions->isNotEmpty())
    <div class="container">
      <table class="table table-hover">
          <thead>
              <tr>
                <th scope="col">Order Id</th>
                <th scope="col">Gross Amount</th>
                <th scope="col">Address</th>
                <th scope="col">Courier</th>
                <th scope="col">Time</th>
                <th scope="col">Status</th>
                {{-- <th scope="col">Metadata</th> --}}
                <th scope="col">Process</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($transactions as $transaction)
                <tr>
                  @if ($transaction->process_status == 'unconfirm' && $transaction->transaction_status == 'settlement')
                    <td><i class="bi bi-circle-fill text-success" style="font-size: 0.5rem;"></i> {{ $transaction->order_id }}</td>
                  @elseif ($transaction->process_status == 'unconfirm' && $transaction->transaction_status == 'pending')
                    <td><i class="bi bi-circle-fill text-warning" style="font-size: 0.5rem;"></i> {{ $transaction->order_id }}</td>
                  @else
                    <td>{{ $transaction->order_id }}</td>
                  @endif
                  <td>Rp{{ number_format($transaction->gross_amount) }}</td>
                  <td>{{ $transaction->shipping->address }}</td>
                  <td>{{ $transaction->shipping->courier }}</td>
                  <td>{{ $transaction->transaction_time }}</td>
                  {{-- <td>{{ $transaction->metadata }}</td> --}}
                  <td>
                    <span class="badge bg-{{ $transaction->transaction_status === 'settlement' ? 'success' : ($transaction->transaction_status === 'pending' ? 'warning' : 'danger') }}">
                      {{ ucfirst($transaction->transaction_status) }}
                  </span>
                  </td>
                  <td>
                      @php
                          $statusClasses = [
                              'success' => 'success',
                              'unconfirm' => 'warning',
                              'process' => 'info',
                              'shipping' => 'primary',
                          ];
                          $badgeClass = $statusClasses[$transaction->process_status] ?? 'danger';
                      @endphp

                      <span class="badge bg-{{ $badgeClass }}">
                          {{ ucfirst($transaction->process_status) }}
                      </span>
                  </td>
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
  @else
      <div class="alert alert-warning text-center py-5 my-4">
          <i class="bi bi-exclamation-circle display-3 text-warning"></i>
          <h4 class="mt-3">No transactions found for the search input.</h4>
      </div>
  @endif
@endisset

{{-- Pagination --}}
{{ $transactions->links() }}
@endsection