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
    Schema::create('leads', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('company_name');
        $table->string('email');
        $table->string('phone');
        $table->enum('source',['Instagram','Website','Reference','Cold Call']);
        $table->string('stage')->default('New Lead');
        $table->foreignId('assigned_to')->nullable()->constrained('users');
        $table->decimal('expected_value',10,2)->nullable();
        $table->text('remarks')->nullable();
        $table->text('lost_reason')->nullable();
        $table->foreignId('created_by')->constrained('users');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
