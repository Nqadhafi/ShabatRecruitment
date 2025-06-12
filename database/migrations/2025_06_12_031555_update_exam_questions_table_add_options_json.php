<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateExamQuestionsTableAddOptionsJson extends Migration
{
    public function up()
    {
        Schema::table('exam_questions', function (Blueprint $table) {
            // 1. Hapus kolom lama yang sudah tidak dipakai
            $table->dropColumn(['option_a', 'option_b', 'option_c', 'option_d']);
            $table->dropColumn(['point_a', 'point_b', 'point_c', 'point_d']);

            // 2. Tambahkan kolom JSON baru
            $table->json('options')->nullable()->after('question_text'); // Simpan semua opsi jawaban
            $table->json('points')->nullable()->after('correct_answer'); // Simpan poin tiap jawaban
        });
    }

    public function down()
    {
        Schema::table('exam_questions', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->text('option_a')->nullable();
            $table->text('option_b')->nullable();
            $table->text('option_c')->nullable();
            $table->text('option_d')->nullable();

            $table->integer('point_a')->default(0);
            $table->integer('point_b')->default(0);
            $table->integer('point_c')->default(0);
            $table->integer('point_d')->default(0);

            // Hapus kolom json
            $table->dropColumn(['options', 'points']);
        });
    }
}