<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('order_id')->nullable()->unique()->after('tanggal');
            $table->string('payment_method')->nullable()->after('order_id');
            $table->string('payment_channel')->nullable()->after('payment_method');
            $table->string('midtrans_transaction_id')->nullable()->after('payment_channel');
            $table->longText('payment_response')->nullable()->after('midtrans_transaction_id');
            $table->dateTime('settled_at')->nullable()->after('payment_response');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn([
                'order_id',
                'payment_method',
                'payment_channel',
                'midtrans_transaction_id',
                'payment_response',
                'settled_at',
            ]);
        });
    }
};
