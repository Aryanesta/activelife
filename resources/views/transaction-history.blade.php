@extends('layouts.profile')

@section('nav-detail')
<div class="card-body p-4">
    <h4 class="fw-bold mb-4">Transaction History</h4>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Gross Amount</th>
                    <th scope="col">Courier</th>
                    <th scope="col">Service</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Process</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->order_id }}</td>
                    <td>Rp{{ number_format($transaction->gross_amount, 0, ',', '.') }}</td>
                    {{-- <td class="text-truncate" style="max-width: 150px;">{{ $transaction->shipping->address }}</td> --}}
                    <td>{{ $transaction->shipping->courier }}</td>
                    <td>{{ $transaction->shipping->courier_service }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->transaction_time)->format('d M Y, H:i') }}</td>
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
                        @if ($transaction->transaction_status === 'settlement')                            
                            <a href="{{ route('invoice', $transaction->order_id) }}"
                                class="btn btn-danger btn-sm transaction-detail-trigger" 
                                data-transaction-id="{{ $transaction->id }}">
                                <i class="bi bi-eye"></i>
                            </a>
                        @elseif ($transaction->transaction_status === 'pending')
                            <button
                                class="btn btn-warning btn-sm text-white pay-button" 
                                data-snap-token="{{ $transaction->snap_token }}"
                                data-transaction-id="{{ $transaction->id }}">
                                <i class="bi bi-credit-card"></i>
                            </button>
                        @else
                            <span class="fw-bold d-flex justify-content-center">---</span>
                            {{-- <span class="bi bi-x btn btn-sm btn-light" style="cursor: default"></span> --}}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
{{ $transactions->links() }}

<script>
    $(document).on('click', '.pay-button', function() {

        let snapToken = $(this).data('snap-token');
        let transactionId = $(this).data('transaction-id');        

        function updateResponse(response) {
            // Kirim data pembayaran ke server
            $.ajax({
                url: `/api/midtrans-callback`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                data: {
                    checkoutData: JSON.stringify(response),
                    id: transactionId
                },
                success: function(data) {
                    console.log('Success:', data);
                    location.reload();
                    // window.location.href = "{{ route('transaction-history') }}";
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                }
            });
        }

        snap.pay(snapToken, {
            onSuccess: function(result) {
                updateResponse(result);
            },
            onPending: function(result) {
                updateResponse(result);
                alert('Payment Pending!');
                console.log(result);
            },
            onError: function(result) {
                console.log(result);
                
                updateResponse(result);
                alert('Payment Error!');
                location.reload();
            }
        });
    });
</script>


@endsection