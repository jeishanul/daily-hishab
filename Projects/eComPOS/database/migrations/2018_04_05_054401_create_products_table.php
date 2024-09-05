<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Media;
use App\Models\Tax;
use App\Models\Unit;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('code');
            $table->string('type');
            $table->string('barcode_symbology');
            $table->foreignIdFor(Brand::class)->constrained()->cascadeOnDelete();
            $table->foreignIdfor(Category::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Unit::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Unit::class, 'purchase_unit_id')->constrained('units')->cascadeOnDelete();
            $table->foreignIdFor(Unit::class, 'sale_unit_id')->constrained('units')->cascadeOnDelete();
            $table->double('cost', 25, 2);
            $table->double('price', 25, 2);
            $table->integer('qty')->nullable();
            $table->integer('alert_quantity')->nullable();
            $table->boolean('is_promotion_price')->default(0);
            $table->double('promotion_price', 25, 2)->nullable();
            $table->timestamp('starting_date')->nullable();
            $table->timestamp('ending_date')->nullable();
            $table->foreignIdFor(Tax::class)->nullable()->constrained();
            $table->string('tax_method')->nullable();
            $table->foreignIdFor(Media::class)->nullable()->constrained();
            $table->text('more_images')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_batch')->default(0);
            $table->text('product_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
