<?php

use App\Enums\ShippingType;
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
        Schema::table('shippings', function (Blueprint $table) {
            $table->enum('type', ShippingType::TYPES)->default(ShippingType::PRZELEW)->after('shipping');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shippings', function (Blueprint $table) {
            //
        });
    }
};