<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('place_categories')) {
            Schema::drop('place_categories');
        }

        if (Schema::hasColumn('places', 'category_id')) {
            $driver = Schema::getConnection()->getDriverName();
            if ($driver === 'mysql') {
                try {
                    DB::statement('ALTER TABLE places DROP FOREIGN KEY places_category_id_foreign');
                } catch (\Throwable $e) {
                    // ignore if FK doesn't exist
                }
            }

            Schema::table('places', function (Blueprint $table) {
                try {
                    if (method_exists($table, 'dropConstrainedForeignId')) {
                        $table->dropConstrainedForeignId('category_id');
                        return; // column dropped with FK
                    }
                } catch (\Throwable $e) {
                    // fallback to plain drop
                }

                if (Schema::hasColumn('places', 'category_id')) {
                    $table->dropColumn('category_id');
                }
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('place_categories')) {
            Schema::create('place_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('slug')->nullable()->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('places', 'category_id')) {
            Schema::table('places', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->after('city_id')->constrained('place_categories')->nullOnDelete();
            });
        }
    }
};
