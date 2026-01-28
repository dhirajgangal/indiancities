<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('city_id')->constrained('place_categories')->nullOnDelete();
            if (Schema::hasColumn('places', 'type')) {
                $table->dropColumn('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            if (Schema::hasColumn('places', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }
            // Optional: recreate type column if needed
            // $table->enum('type', ['tourist_place', 'restaurant', 'temple'])->nullable();
        });
    }
};
