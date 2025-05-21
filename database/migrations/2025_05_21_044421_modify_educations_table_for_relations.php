<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEducationsTableForRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    Schema::table('educations', function (Blueprint $table) {
        // Menghapus foreign key constraint terkait grade_uuid
        $table->dropForeign(['grade_uuid']);
        
        // Menghapus kolom 'grade_uuid' setelah foreign key dihapus
        $table->dropColumn('grade_uuid');
        
        // Menambahkan kolom 'majority_uuid' untuk relasi ke tabel 'majorities'
        $table->char('majority_uuid', 36); // Char dengan panjang 36 untuk UUID
        
        // Membuat foreign key untuk relasi dengan tabel 'majorities'
        $table->foreign('majority_uuid')
              ->references('id') // kolom 'id' pada tabel 'majorities'
              ->on('majorities') // nama tabel 'majorities'
              ->onDelete('cascade'); // Menghapus data di 'educations' jika data di 'majorities' dihapus
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::table('educations', function (Blueprint $table) {
        // Menambahkan kembali kolom 'grade_uuid' jika rollback
        $table->char('grade_uuid', 36);
        
        // Menghapus kolom 'majority_uuid' dan foreign key-nya
        $table->dropForeign(['majority_uuid']);
        $table->dropColumn('majority_uuid');
    });
    }
}
