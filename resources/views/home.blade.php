@extends('layouts.main')

@section('container')
<div class="container">
    <!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">

    <!-- Indicators/dots -->
    <div class="carousel-indicators">
    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
    </div>

    <!-- The slideshow/carousel -->
    <div class="carousel-inner">
    <div class="carousel-item active">
        <img src="https://johnsonfitness.id/wp-content/uploads/2024/10/10.10-WEB.png" alt="Los Angeles" class="d-block w-100">
    </div>
    <div class="carousel-item">
        <img src="https://johnsonfitness.id/wp-content/uploads/2024/10/10.10-WEB.png" alt="Chicago" class="d-block w-100">
    </div>
    <div class="carousel-item">
        <img src="https://johnsonfitness.id/wp-content/uploads/2024/10/10.10-WEB.png" alt="New York" class="d-block w-100">
    </div>
    </div>

    <!-- Left and right controls/icons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
    </button>
</div>
</div>
@endsection