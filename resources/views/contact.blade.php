@extends('layouts.main')

@section('container')

<div class="container mt-5">
    <div class="row">
        <!-- Contact Information Section -->
        <div class="col-md-6 mb-4">
            <h3 class="mb-4 text-danger">Contact Information</h3>
            <ul class="list-unstyled">
                <li><strong class="text-secondary">Address:</strong> <span class="text-muted">24 Dharmawangsa Street, Jember City</span></li>
                <li><strong class="text-secondary">Email:</strong> <span class="text-muted">activelife@gmail.com</span></li>
                <li><strong class="text-secondary">Phone:</strong> <span class="text-muted">+1 234 567 890</span></li>
                <li><strong class="text-secondary">Business Hours:</strong> <span class="text-muted">Mon - Fri, 9:00 AM - 6:00 PM</span></li>
            </ul>
        </div>

        <!-- Location Section -->
        <div class="col-md-6">
            <h3 class="mb-4 text-danger">Our Location</h3>
            <div class="map-container mb-3" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1284.766875717893!2d113.63195306210352!3d-8.197556684573179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd691701cddaee3%3A0x9854ada1735da5e2!2sJl.%20Dharmawangsa%20No.24%2C%20Jubung%20Lor%2C%20Jubung%2C%20Kec.%20Sukorambi%2C%20Kabupaten%20Jember%2C%20Jawa%20Timur%2068151!5e0!3m2!1sid!2sid!4v1733821456681!5m2!1sid!2sid" 
                    class="w-100 h-100 border-0" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</div>


<style>
    .map-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .container {
        background-color: #f9f9f9;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h3 {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .text-primary {
        color: #007bff !important;
    }
    .text-secondary {
        color: #333 !important;
    }
    .text-muted {
        color: #6c757d;
    }
    .map-container {
        border-radius: 8px;
        overflow: hidden;
    }
    @media (max-width: 768px) {
        .col-md-6 {
            margin-bottom: 20px;
        }
    }
</style>

@endsection