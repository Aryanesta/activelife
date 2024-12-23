@extends('layouts.main')

{{-- @dd($cart_products) --}}


@section('container')

{{-- @if (session()->has('delete-success'))
    <script>
        toastr.success("{{ session('delete-success') }}");
    </script>
@endif --}}


<div class="parent container">
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Your Cart</h3>
        </div>
        <div class="card-body d-flex justify-content-center gap-2 row" id="cart-card">

            @if (!empty($cart_products[0]))                
                @if (count($cart_products[0]->cartItems) < 1)
                    <div class="col-md-12 text-center">
                        <h3 class="text-center text-secondary">Your cart is empty!</h3>
                    </div>
                @else
                    @foreach ($cart_products as $cartItem)  
                        @foreach ($cartItem->cartItems as $item)                
                        {{-- Item Keranjang --}}
                        <div class="card mb-2 col-xl-5 cart-card-root">
                            <div class="row g-0">
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <img src="storage/{{ $item->product->image }}" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-header bg-white mt-2">
                                        <h5 class="card-title">{{ $item->product->name }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div>
                                                <p class="card-text">Harga: Rp. {{ number_format($item->product->price) }}</p>
                                            </div>
                                            <input type="checkbox" name="selected-items" style="width: 20px; height: 20px" class="selected-items" 
                                            data-selected-item-id='{{ $item->product->id }}' 
                                            data-selected-item-price='{{ $item->product->price }}' 
                                            data-selected-item-quantity='{{ $item->quantity }}'
                                            data-selected-item-name='{{ $item->product->name }}'
                                            data-selected-cart-id='{{ $item->id }}'
                                            id="awal">
                                        </div>
                                        <div class="d-flex gap-2 align-content-center justify-content-centers w-75">
                                            <div>
                                                <form action="/user-cart/{{ $item->id }}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger deleteCartItem" data-id="{{ $item->id }}"><i class="bi bi-trash3"></i></button>
                                                </form>
                                            </div>
                                            <div class="input-group mb-3">
                                                <button class="input-group-text min-quantity" data-item-id="{{ $item->id }}">-</button>
                                                <input type="number" class="form-control bg-white quantity-input" value="{{ $item->quantity }}" disabled>
                                                <input type="hidden" class="form-control bg-white price-input" value="{{ $item->price }}" disabled id='price-input'>
                                                <input type="hidden" class="form-control bg-white weight-input" value="{{ $item->weight }}" disabled id='weight-input'>
                                                <button class="input-group-text plus-quantity" data-item-id="{{ $item->id }}">+</button>
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach          
                    @endforeach
                @endif  
            @else
                <div class="col-md-12 text-center">
                    <h3 class="text-center text-secondary">Your cart is empty!</h3>
                </div>   
            @endif
        </div>
        {{-- Item Keranjang ENd --}}
    </div>
    
    @if (!empty($cart_products[0]))     
        @if (count($cart_products[0]->cartItems) > 0)        
            {{-- CHECK OUT! --}}
            <div class="m-1" id="checkout">
                <form action="/admin/ongkir" method="POST" id="cekCost" class="gap-2 justify-content-center row">
                    @csrf
                    <div class="card mb-3 col-lg-7 p-0">
                        <div class="card-header">
                            Shipping Information
                        </div>
                        <div class="card-body">
                    
                                {{-- Address --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="province-destination" class="form-label">Provinsi</label>
                                        <select name="province-destination" class="form-control select2" id="province-destination" required>
                                            <option value="" disabled selected hidden></option>
                                            {{-- Options akan diisi melalui AJAX --}}
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" value="160" name="origin" id="origin">
                                        <label for="destination" class="form-label">Kota</label>
                                        <select name="destination" class="form-control select2" id="destination" required disabled>
                                            <option value="" disabled selected hidden></option>
                                            {{-- Options akan diisi melalui AJAX --}}
                                        </select>
                                    </div>
                                </div>
                    
                                {{-- Kurir & Service --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="courier" class="form-label">Pilih Jasa Pengiriman</label>
                                        <select name="courier" class="form-control select2" id="courier" disabled required>
                                            <option value="" disabled selected hidden></option>
                                            <option value="jne">JNE</option>
                                            <option value="pos">Pos Indonesia</option>
                                            <option value="tiki">TIKI</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="services" class="form-label">Pilih Layanan</label>
                                        <select name="services" id="services" class="form-control select2" disabled required>
                                            <option value="" disabled selected hidden></option>
                                            {{-- Diisi melalui AJAX --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div>
                                        <label for="address-detail" class="form-label">Detail Alamat</label>
                                        <input type="text" name="address-detail" id="address-detail" class="form-control" value="{{ auth()->user()->address }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div>
                                        <label for="metadata" class="form-label">Informasi Tambahan (Opsional)</label>
                                        <input type="text" name="metadata" id="metadata" class="form-control">
                                    </div>
                                </div>
                        </div>
                    </div>


                    {{-- Summary --}}
                    <div class="card mb-3 col-lg-4 p-0" id='totalCostContainer'>
                        <div class="card-header">
                        Summary
                        </div>
                        <div class="card-body">
                            <div class='p-0' id='dlvInfo'>
                                {{-- Diisi menggunakan AJAX --}}
                                {{-- <h4 class="text-secondary text-center">None</h4> --}}
                                <p class="text-title">Shipping from <b>Jember</b></p>
                                <h6 class="card-title">
                                    <span>
                                        Product : Rp. <input type="number" disabled class="bg-white border-0 fw-bold w-50" value="0" id="total-product">
                                        <input type="hidden" class="bg-white border-0 fw-bold text-danger w-50" disabled value="0" id="total-weight">
                                    </span>
                                </h6>
                                <h6 class="card-title">
                                    <span>
                                        Ongkir : Rp. <input type="number" disabled class="bg-white border-0 fw-bold w-50" value="0" id="ongkir-price">
                                    </span>
                                </h6>
                                <h5 class="card-title">Total :
                                    <span class="summary-text text-danger fw-bold">Rp.
                                        <input type="number" disabled class="bg-white border-0 fw-bold text-danger w-50" value="0" id="total-price">
                                    </span>
                                </h5>                
                            </div>
                            {{-- Button --}}
                            <button class="btn btn-danger" type="submit" id="pay-button">Proceed to Checkout</button>
                            {{-- <button class="btn btn-danger mt-2" id="pay-button">Checkout Test</button> --}}
                        </div>
                    </div>
                </form>
            </div>
        @endif
    @endif
</div>

{{-- CHECKOUT END! --}}



{{-- SCRIPTTT JAVASCRIPTT --}}
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Choose one..",
        });

        // Delete
        $(document).on('click', '.deleteCartItem', function(e) {
            e.preventDefault();
            let itemId = $(this).data('id');
            let cartItem = $(this).closest('.cart-card-root');

            $.ajax({
                url: '{{ route("cart.destroy", "") }}/' + itemId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    cartItem.remove();

                    $('#cart-quantity').html(response.updatedCartQuantity);
                    if ($('#cart-card .cart-card-root').length === 0) {
                        location.reload();
                    }

                    toastr.success("Item berhasil dihapus dari keranjang!");

                },
                error: function(xhr) {
                    toastr.error("Gagal menghapus item dari keranjang!" + xhr);
                }
            });
        });

        // Button untuk menambah quantity
        $('.plus-quantity').on('click', function() {
            let id = $(this).data('item-id');
            let quantityInput = $(this).siblings('.quantity-input');
            let priceInput = $(this).siblings('.price-input');
            let weightInput = $(this).siblings('.weight-input');
            let currentQuantity = parseInt(quantityInput.val());
            let checkBox = $(this).closest('.card-body').find('#awal');

            if (!checkBox.is(':checked')) {
                $.ajax({
                    url: `/user-cart/${id}/`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        item_id: id,
                        quantity: currentQuantity + 1
                    },
                    success: function(response) {
                        quantityInput.val(response.newQuantity);
                        priceInput.val(response.newPrice);
                        weightInput.val(response.newWeight);
                    },
                    error: function(xhr) {
                        console.log('Error updating quantity');
                    }
                });
            }
        });


        // Button untuk mengurangi quantity
        $('.min-quantity').on('click', function() {
            let id = $(this).data('item-id');
            let quantityInput = $(this).siblings('.quantity-input');
            let priceInput = $(this).siblings('.price-input');
            let weightInput = $(this).siblings('.weight-input');
            let currentQuantity = parseInt(quantityInput.val());
            let checkBox = $(this).closest('.card-body').find('#awal');

            if (!checkBox.is(':checked') && quantityInput.val() > 1){
                $.ajax({
                    url: `/user-cart/${id}/`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        item_id: id,
                        quantity: currentQuantity - 1
                    },
                    success: function(response) {
                        quantityInput.val(response.newQuantity);
                        priceInput.val(response.newPrice);
                        weightInput.val(response.newWeight);

                    },
                    error: function(xhr) {
                        console.log('Error updating quantity');
                    }
                });
            }
        });

        // $('.selected-items').on('change', function() {
        //     let inputPrice = parseInt($(this).closest('.card-body').find('#price-input').val());
        //     let inputWeight = parseInt($(this).closest('.card-body').find('#weight-input').val());
            
        //     let productPrice = Number($('#total-product').val());
        //     let totalWeight = Number($('#total-weight').val());
        //     let ongkir = Number($('#services').val()) || 0;
        //     let totalPrice = Number($('#total-price').val());
            
        //     if ($(this).is(':checked')) {
        //         productPrice += inputPrice;
        //         totalWeight += inputWeight;
        //         totalPrice = productPrice + ongkir;
        //     } else {
        //         productPrice -= inputPrice;
        //         totalWeight -= inputWeight;
        //         totalPrice = productPrice + ongkir;
        //     }

        //     $('#total-product').val(productPrice);
        //     $('#total-weight').val(totalWeight);
        //     $('#total-price').val(totalPrice);
        // });


        // Fungsi untuk menghitung total harga
        function calculateTotal() {
            let productPrice = 0;
            let totalWeight = 0;
            let ongkir = Number($('#services').val()) || 0;
            let totalPrice = 0;

            // Iterate semua checkbox yang dipilih
            $('.selected-items').each(function() {
                let inputPrice = parseInt($(this).closest('.card-body').find('#price-input').val());
                let inputWeight = parseInt($(this).closest('.card-body').find('#weight-input').val());

                if ($(this).is(':checked')) {
                    productPrice += inputPrice;
                    totalWeight += inputWeight;
                }
            });

            totalPrice = productPrice + ongkir;

            // Update nilai total ke elemen input
            $('#total-product').val(productPrice);
            $('#total-weight').val(totalWeight);
            $('#total-price').val(totalPrice);
        }

        // Event handler untuk perubahan checkbox
        $('.selected-items').on('change', function() {
            // Hitung ulang total harga setiap kali checkbox berubah
            calculateTotal();

            // Simpan status checkbox ke localStorage
            saveCartState();
        });

        // Fungsi untuk menyimpan status checkbox ke localStorage
        function saveCartState() {
            let cartState = [];
            $('.selected-items').each(function() {
                cartState.push({
                    id: $(this).attr('id'),
                    checked: $(this).is(':checked')
                });
            });
            localStorage.setItem('cartState', JSON.stringify(cartState));
        }

        // Fungsi untuk memuat status checkbox dari localStorage
        function loadCartState() {
            let cartState = JSON.parse(localStorage.getItem('cartState'));
            if (cartState) {
                $('.selected-items').each(function() {
                    let state = cartState.find(item => item.id === $(this).attr('id'));
                    if (state) {
                        $(this).prop('checked', state.checked);
                    }
                });

                // Setelah memuat status, hitung ulang total harga
                calculateTotal();
            }
        }

        // Panggil loadCartState ketika halaman dimuat
        $(document).ready(function() {
            loadCartState();
        });


        // $('.selected-items').on('click', function() {
        //     console.log($(this).data('selected-item-id'));
        // });

        // PEMBAYARAN
        $('#pay-button').on('click', function(event) {
            event.preventDefault();

            if (!$('.selected-items:checked').length > 0) {
                alert('Mohon Pilih Produk Terlebih Dahulu!')
                location.reload();
            }

            let province_destination = $('#province-destination option:selected').text();
            let destination = $('#destination option:selected').text();
            let address_detail = $('#address-detail').val();

            let checkoutData = {
                address: `${address_detail}, ${destination}, ${province_destination}`,
                courier: $('#courier option:selected').text(),
                service: $('#services option:selected').text(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                metadata: $('#metadata').val(),
                selected_items: [{
                    id: 'Shipping',
                    price: $('#ongkir-price').val(),
                    quantity: 1,
                    name: 'Ongkos Kirim'
                }],
                amount: $('#total-price').val()
            };

            // Mengumpulkan data produk yang dipilih
            $('.selected-items:checked').each(function() {
                
                let inputQuantity = parseInt($(this).closest('.card-body').find('.quantity-input').val());

                let selectedItem = {
                    id: $(this).data('selected-item-id'),
                    price: $(this).data('selected-item-price'),
                    quantity: inputQuantity,
                    name: $(this).data('selected-item-name'),
                    cart_id: $(this).data('selected-cart-id')
                };
                checkoutData.selected_items.push(selectedItem);
            });

            // checkoutData.total_price = $('#total-product').val();

            function storeResponse(response, snapToken) {
                snapToken = snapToken;
                checkoutData.selected_items.splice(0, 1);

                $.ajax({
                    url: '/payment/finish',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: {
                        checkoutData: JSON.stringify(response),
                        items: JSON.stringify(checkoutData.selected_items),
                        ongkir: $('#ongkir-price').val(),
                        address: checkoutData.address,
                        courier: checkoutData.courier,
                        service: checkoutData.service,
                        metadata: checkoutData.metadata,
                        snapToken: snapToken,
                    },
                    success: function(data) {
                        console.log('Success', data);
                    },
                    error: function(xhr) {
                        console.log('Error', xhr);
                    }
                });
            }

            if ($('#services').val() && $('#address-detail').val()) {
                            
                $.ajax({
                    url: '/payment',
                    type: 'GET',
                    data: {
                        items: checkoutData.selected_items,
                        amount: checkoutData.amount,
                        address: checkoutData.address,
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        
                        let snapToken = response.snap_token;
                        snap.pay(snapToken, {
                            onSuccess: function(result) {
                                // console.log('payment success', result);

                                storeResponse(result, snapToken);
                                let cartItem = $('.selected-items:checked').closest('.cart-card-root');
       
                                checkoutData.selected_items.forEach(element => {
       
                                    $.ajax({
                                        url: `/user-cart/${element.cart_id}`,
                                        type: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        success: function(response) {
                                            cartItem.remove();
                                            window.location.href = "{{ route('transaction-history') }}";
                                        },
                                        error: function(xhr) {
                                            console.log('Gagal menghapus item dari keranjang:', xhr);
                                        }
                                    });
                                });
       
                            },
                            onPending: function(result) {
                                storeResponse(result, snapToken);
                                alert('Payment Pending!');
                                console.log(result);
                                window.location.href = "{{ route('transaction-history') }}";
                            },
                            onError: function(result) {
                                storeResponse(result, snapToken);
                                alert('Payment Error!');
                                console.log(result);
                            }
                        });
                    },
                    error: function(xhr) {
                        console.log('Checkout gagal:', xhr);
                        toastr.error(xhr.responseJSON.error);
                        // alert('Checkout gagal. Silakan coba lagi.');
                    }
                });
            } else {
                alert('Mohon lengkapi informasi pengiriman terlebih dahulu!');
            }

        });


        // $('.selected-items').on('change', function() {
        //     if ($('.selected-items:checked').length > 0) {
        //         $('#checkout').css('display', 'flex');
        //     } else {
        //         $('#checkout').css('display', 'none');
        //     }
        // });

        // Rajaongkir
        $.ajax({
            url: '/api/province',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                let result = response;

                result.forEach(function(data) {
                    let province = `
                        <option value="${data.province_id}">${data.province}</option>
                    `;
                    $('#province-destination').append(province);
                });
            },
            error: function(xhr) {
                console.log('Gagal mengambil data provinsi:', xhr);
            }
        });

        $('#province-destination').on('change', function() {
            let selectedProvince = parseInt($(this).val());

            $.ajax({
                url: `/api/city/${selectedProvince}`,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#destination').empty();

                    let dflt = `<option value="" disabled selected hidden></option>`;
                    $('#destination').append(dflt);

                    response.forEach(function(data) {
                        let city = `<option value="${data.city_id}">${data.city_name}</option>`;
                        $('#destination').append(city);
                    });
                    $('#destination').removeAttr('disabled');
                },
            });
        })

        $('#destination').on('change', function() {
            $('#courier').removeAttr('disabled');
        })

        $('#courier').on('change', function() {
            const origin = $('#origin').val();
            let destination = $('#destination').val();
            let weight = parseInt($('#total-weight').val());
            let courier = $(this).val();

            $.ajax({
                url: `/api/cost`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    origin: origin,
                    destination: destination,
                    weight: weight,
                    courier: courier
                },
                success: function(response) {
                    let results = response[0].costs;

                    $('#services').empty();
                        
                    let dflt = `<option value="" disabled selected hidden></option>`;
                    $('#services').append(dflt);
            
                    results.forEach(function(data) {
                        let service = `<option value="${data.cost[0].value}">${data.description} (${data.service})</option>`;
                        $('#services').append(service);
                    });

                    $('#services').removeAttr('disabled');
                }
            });

            $('.selected-items').on('change', function() {

                const origin = $('#origin').val();
                let destination = $('#destination').val();
                let weight = parseInt($('#total-weight').val());
                let courier = $('#courier').val();

                $.ajax({
                    url: `/api/cost`,
                    type: 'POST',
                    data: {
                        origin: origin,
                        destination: destination,
                        weight: weight,
                        courier: courier
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        let results = response[0].costs;
                        $('#services').empty();
                        
                        let dflt = `<option value="" disabled selected hidden></option>`;
                        $('#services').append(dflt);
            
                        results.forEach(function(data) {
                            let service = `<option value="${data.cost[0].value}">${data.description} (${data.service})</option>`;
                            $('#services').append(service);
                        });

                        $('#services').removeAttr('disabled');
                    }
                });
            });

        });

        
        $('#services').on('change', function() {
            let productPrice = parseFloat($('#total-product').val());

            let ongkir = parseFloat($(this).val());

            $('#ongkir-price').val(ongkir);

            let totalPrice = productPrice + ongkir;
            $('#total-price').val(totalPrice);
        });



    });

</script>
@endsection