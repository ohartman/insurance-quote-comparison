<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained()->onDelete('cascade');
            $table->enum('coverage_type', ['liability', 'collision', 'comprehensive', 'full']);
            $table->decimal('monthly_premium', 10, 2);
            $table->decimal('deductible', 10, 2);
            $table->decimal('coverage_limit', 12, 2);
            $table->string('customer_name');
            $table->string('customer_email');
            $table->integer('vehicle_year');
            $table->string('vehicle_make');
            $table->string('vehicle_model');
            $table->timestamps();

            $table->index(['coverage_type', 'monthly_premium']);
            $table->index('provider_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
