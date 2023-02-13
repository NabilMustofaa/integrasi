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
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_question_id')->constrained('survey_questions');
            $table->foreignId('question_option_id')->nullable()->constrained('question_options');
            $table->foreignId('survey_plan_id')->constrained('survey_plans');
            $table->string('answer')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_answers');
    }
};
