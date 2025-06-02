<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Menambahkan kolom min_grades sebagai string untuk menyimpan UUID
            $table->string('min_grades')->nullable();

            // Menambahkan foreign key pada kolom min_grades yang merujuk ke uuid di tabel grades
            $table->foreign('min_grades')->references('id')->on('grades')->onDelete('set null');

            // Menambahkan kolom gender sebagai enum untuk pilihan Male, Female, Other
            $table->enum('gender', ['Pria', 'Wanita', 'Pria/Wanita'])->nullable();

            // Menambahkan kolom contract sebagai string (jenis kontrak pekerjaan)
            $table->string('contract')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Menghapus foreign key pada kolom min_grades
            $table->dropForeign(['min_grades']);

            // Menghapus kolom min_grades, gender, dan contract
            $table->dropColumn(['min_grades', 'gender', 'contract']);
        });
    }
}
