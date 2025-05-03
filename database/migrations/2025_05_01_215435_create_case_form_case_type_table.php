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
        Schema::create('case_form_case_type', function (Blueprint $table) {
            $table->unsignedBigInteger('case_id');
            $table->unsignedBigInteger('case_type_id');

            $table->primary(['case_id', 'case_type_id']);

            $table->foreign('case_id')->references('case_id')->on('case_forms')->onDelete('cascade');
            $table->foreign('case_type_id')->references('case_type_id')->on('case_types')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_form_case_type');
    }
};
