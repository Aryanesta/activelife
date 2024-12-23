@extends('layouts.dashboard')

{{-- @dd($customerCount) --}}

@section('container')
<div class="container py-4 mb-5">
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-header fw-bold">
                    Products
                </div>
                <div class="card-body">
                    <h1 class="display-6 mb-0">{{ $productCount }}</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-header fw-bold">
                    Customers
                </div>
                <div class="card-body">
                    <h1 class="display-6 mb-0">{{ $customerCount }}</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-header fw-bold">
                    Transactions
                </div>
                <div class="card-body">
                    <h1 class="display-6 mb-0">{{ $transactionCount }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-5">
            <h5 class="my-2">Summary (This Year)</h5>
        </div>
        <div class="card-body my-2">
            <h2>Rp{{ $totalIncome }}</h2>
        </div>
    </div>

    {{-- Cart --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="my-2">Income Chart</h5>
        </div>
        <div class="card-body">
            <canvas id="incomeChart"></canvas>
        </div>
    </div>
</div>

<script>
const labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "Desember"];
const incomeData = Array(12).fill(0);

$.ajax({
    type: "GET",
    url: "/api/admin/income",
    success: function(responseData) {
        console.log(responseData);
        

        const income = responseData['incomeData'];

        income.forEach((item) => {
            const index = item.month - 1;
            if (index >= 0 && index < incomeData.length) {
                incomeData[index] = parseInt(item.total_income) || 0; 
            }
        });

        const chartData = {
            labels: labels,
            datasets: [{
                label: `Income ${income[0].year}`,
                data: incomeData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
            }]
        };

        const config = {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const incomeChart = new Chart(
            document.getElementById('incomeChart'),
            config
        );
    }
});

</script>

@endsection