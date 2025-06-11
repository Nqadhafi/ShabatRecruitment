<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRandomAndDurationToExamTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_titles', function (Blueprint $table) {
            //
            $table->boolean('is_random')->default(false)->comment('Jika true, soal akan diacak saat ujian');
            $table->integer('duration_minutes')->nullable()->comment('Durasi ujian dalam menit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_titles', function (Blueprint $table) {
            //
                   $table->dropColumn(['is_random', 'duration_minutes']);
        });
    }
}
