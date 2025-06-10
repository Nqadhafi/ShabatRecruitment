<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_title_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->string('image_path')->nullable();
            $table->text('option_a');
            $table->text('option_b');
            $table->text('option_c');
            $table->text('option_d');

            // Untuk benar/salah
            $table->char('correct_answer', 1)->nullable(); 

            // Untuk tipe poin
            $table->integer('point_a')->default(0);
            $table->integer('point_b')->default(0);
            $table->integer('point_c')->default(0);
            $table->integer('point_d')->default(0);

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
        Schema::dropIfExists('exam_questions');
    }
}
