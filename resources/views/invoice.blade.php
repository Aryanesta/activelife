@extends('layouts.main')

{{-- @dd($invoice) --}}

@section('container')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <!-- Header -->
                <div class="card-header bg-danger bg-gradient text-white text-center py-4">
                    <h2 class="h4 mb-1">Invoice</h2>
                    <p class="mb-0">Invoice #: <strong>#INV-{{ $invoice->transaction_id }}</strong></p>
                    <p>Date: <strong>{{ $invoice->created_at->format('d M Y, H:i') }}</strong></p>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <!-- Pengirim dan Penerima -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="h6 text-danger">ActiveLife</h5>
                            <p class="mb-0">Darmawangsa Main Street</p>
                            <p class="mb-0">Jember, Indonesia</p>
                            <p class="mb-0">Phone: +1234567890</p>
                            <p>Email: activelife@gmail.com</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5 class="h6 text-danger">Billed To:</h5>
                            <p class="mb-0"><strong>{{ $invoice->customer->name }}</strong></p>
                            <p class="mb-0">{{ $invoice->shipping->address }}</p>
                            <p class="mb-0">Phone: {{ $invoice->customer->phone ?? 'Belum tersedia' }}</p>
                            <p>Email: {{ $invoice->customer->email }}</p>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-4 text-center">
                        @if ($invoice->process_status == 'unconfirm')
                            <span class="badge bg-warning text-dark fs-6 py-2 px-4">Status: Waiting Confirmation</span>
                        @elseif ($invoice->process_status == 'process')
                            <span class="badge bg-info fs-6 py-2 px-4">Status: On Process</span>
                        @elseif ($invoice->process_status == 'shipping')
                            <span class="badge bg-primary fs-6 py-2 px-4">Status: Shipped</span>
                        @elseif ($invoice->process_status == 'success')
                            <span class="badge bg-success fs-6 py-2 px-4">Status: Success</span>
                        @elseif ($invoice->process_status == 'reject')
                            <span class="badge bg-danger fs-6 py-2 px-4">Status: Rejected</span>
                        @endif
                    </div>

                    <!-- Tabel Produk -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered"  id="invoice-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->products as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->pivot->quantity }}</td>
                                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($item->price * $item->pivot->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                    <td>Rp{{ number_format($invoice->gross_amount - $invoice->shipping->ongkir, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Shipping:</strong></td>
                                    <td>Rp{{ number_format($invoice->shipping->ongkir, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="4" class="text-end"><strong>Total:</strong></td>
                                    <td><strong>Rp{{ number_format($invoice->gross_amount, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-light d-flex justify-content-between">
                    <a href="{{ route('transaction-history') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    @if ($invoice->process_status == 'shipping')
                        <button type="button" class="btn btn-success" id="finish-order" data-id="{{ $invoice->id }}>
                            <i class="bi bi-check-circle"></i> Selesaikan Pesanan
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#finish-order', function(){
        let id = $(this).data('id');

        $.ajax({
            type: 'PUT',
            url: '/api/admin/transaction/update-status',
            data: {
                transaction_id: id,
                process_status: 'success'
            },
            success: function(data){
                toastr.success(data.message);
                location.reload();
            },
            error: function (xhr, status, error) {
                toastr.error("Terjadi kesalahan: " + error);
            },
        });
    });
</script>
@endsection