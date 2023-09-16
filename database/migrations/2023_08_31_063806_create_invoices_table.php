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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('payout_id')->nullable()->constrained()->references('id')->on('payouts')->onDelete('cascade');
            $table->integer('amount_cents')->nullable();
            $table->string('tax_type')->default('GST');
            $table->double('tax_percentage')->nullable();
            $table->enum('currency', ['AUD', 'USD'])->default('AUD');
            $table->string('stripe_link')->nullable();
            $table->boolean('paid')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
