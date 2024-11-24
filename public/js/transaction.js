function formatCurrency(value) {
    return new Intl.NumberFormat("id-ID").format(value);
}

$(document).ready(function () {
    $(".transaction-detail-trigger").on("click", function () {
        const transactionId = $(this).data("transaction-id");

        if ($("#transaction-detail").css("right", "-100%")) {
            $("#transaction-detail").css("right", "0");
        }

        $.ajax({
            type: "GET",
            url: `/admin/transaction/${transactionId}`, // Sesuaikan URL
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                $("#transaction-detail-body").empty();

                let bodyContent = `
                  <div>
                    <h5 class="text-danger">Rincian Pembayaran</h5>
                    <hr>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Order ID</span>
                      <span class="col-8">${data.transaction.order_id}</span>
                    </small>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Channel</span>
                      <span class="col-8">${
                          data.transaction.payment_type
                      }</span>
                    </small>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Dibuat pada</span>
                      <span class="col-8">${data.transaction.created_at}</span>
                    </small>
                    <small class="row mb-5">
                      <span class="col-4 fw-bold">Dibayar pada</span>
                      <span class="col-8">${
                          data.transaction.transaction_time
                      }</span>
                    </small>
                  </div>
                  <div>
                    <h5 class="text-danger">Rincian Customer</h5>
                    <hr>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Nama Customer</span>
                      <span class="col-8">${
                          data.transaction.customer.name
                      }</span>
                    </small>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Nomor HP</span>
                      <span class="col-8">${
                          data.transaction.customer.phone ?? "-"
                      }</span>
                    </small>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Email</span>
                      <span class="col-8">${
                          data.transaction.customer.email
                      }</span>
                    </small>
                    <small class="row mb-5">
                      <span class="col-4 fw-bold">Alamat</span>
                      <span class="col-8">${
                          data.transaction.shipping.address
                      }</span>
                    </small>
                  </div>
                  <div>
                    <h5 class="text-danger">Rincian Pengiriman</h5>
                    <hr>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Alamat Pengiriman</span>
                      <span class="col-8">${
                          data.transaction.shipping.address
                      }</span>
                    </small>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Kurir</span>
                      <span class="col-8">${
                          data.transaction.shipping.courier
                      }</span>
                    </small>
                    <small class="row mb-3">
                      <span class="col-4 fw-bold">Layanan</span>
                      <span class="col-8">${
                          data.transaction.shipping.courier_service
                      }</span>
                    </small>
                    <small class="row mb-5">
                      <span class="col-4 fw-bold">Ongkos Kirim</span>
                      <span class="col-8">Rp${formatCurrency(
                          data.transaction.shipping.ongkir
                      )}</span>
                    </small>
                  </div>
                  <div id="product-paid">
                    <h5 class="text-danger">Rincian Produk</h5>
                    <hr>
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">ID PRODUK</th>
                          <th scope="col">NAMA PRODUK</th>
                          <th scope="col">JUMLAH</th>
                          <th scope="col">HARGA</th>
                          <th scope="col">SUB TOTAL</th>
                        </tr>
                      </thead>
                      <tbody id="product-tbody">
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="4" class="text-end fw-bold">Ongkos Kirim</td>
                          <td>Rp${formatCurrency(
                              data.transaction.shipping.ongkir
                          )}</td>
                        </tr>
                        <tr>
                          <td colspan="4" class="text-end fw-bold">Total Harga</td>
                          <td>Rp${formatCurrency(
                              data.transaction.gross_amount
                          )}</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                `;

                $("#transaction-detail-body").append(bodyContent);

                let productRows = "";
                data.transaction.products.forEach((product) => {
                    productRows += `
                        <tr>
                          <td>${product.id}</td>
                          <td>${product.name}</td>
                          <td>${product.pivot.quantity}</td>
                          <td>Rp${formatCurrency(product.price)}</td>
                          <td>Rp${formatCurrency(
                              product.pivot.quantity * product.price
                          )}</td>
                        </tr>
                    `;
                });

                $("#product-tbody").append(productRows);
            },
        });
    });

    $("#transaction-detail-closer").on("click", function () {
        if ($("#transaction-detail").css("right", "0")) {
            $("#transaction-detail").css("right", "-100%");
        }
    });
});
