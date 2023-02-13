<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained('surveys');
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('quality_assurance_team_id')->constrained('quality_assurance_teams');
            $table->date('date');
            $table->string('photo')->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_plans');
    }
};
