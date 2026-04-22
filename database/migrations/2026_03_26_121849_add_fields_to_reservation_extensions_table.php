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
        Schema::table('reservation_extensions', function (Blueprint $table) {
            $table->string('new_return_time', 5)->nullable()->after('new_end_date');
            $table->unsignedBigInteger('subtotal')->default(0)->after('days');
            $table->unsignedTinyInteger('discount_percentage')->default(0)->after('subtotal');
            $table->unsignedBigInteger('discount_amount')->default(0)->after('discount_percentage');
            // 'amount' already exists as final total (after discount)
            $table->string('transaction_id')->nullable()->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('reservation_extensions', function (Blueprint $table) {
            $table->dropColumn([
                'new_return_time',
                'subtotal',
                'discount_percentage',
                'discount_amount',
                'transaction_id',
            ]);
        });
    }
};
