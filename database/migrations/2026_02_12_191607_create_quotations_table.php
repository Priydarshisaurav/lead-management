<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('quotations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lead_id')->constrained()->onDelete('cascade');
        $table->string('product_name');
        $table->integer('quantity');
        $table->decimal('rate',10,2);
        $table->integer('gst_percentage');
        $table->decimal('subtotal',10,2);
        $table->decimal('gst_amount',10,2);
        $table->decimal('total_amount',10,2);
        $table->date('valid_till');
        $table->enum('status',['Draft','Sent','Accepted','Rejected'])->default('Draft');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
