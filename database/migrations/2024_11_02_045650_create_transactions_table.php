<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('shipping_id');
            $table->string('transaction_id', 100);
            $table->string('order_id', 100);
            $table->string('payment_type', 100)->nullable();
            $table->bigInteger('gross_amount');
            $table->text('metadata')->nullable();
            $table->string('snap_token')->nullable();
            $table->enum('transaction_status', ['pending', 'settlement', 'cancel', 'expire']);
            $table->timestamp('transaction_time')->useCurrent();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
