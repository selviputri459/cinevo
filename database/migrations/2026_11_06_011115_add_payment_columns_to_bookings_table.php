<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_method')->default('cash')->after('status');
            $table->string('payment_channel')->nullable()->after('payment_method');
            $table->string('sender_account')->nullable()->after('payment_channel');
            $table->string('payment_proof')->nullable()->after('sender_account');
            $table->string('refund_status')->nullable()->after('payment_proof');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method', 'payment_channel', 'sender_account',
                'payment_proof', 'refund_status',
            ]);
        });
    }
};