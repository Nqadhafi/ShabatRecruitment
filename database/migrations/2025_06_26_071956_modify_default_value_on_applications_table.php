<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDefaultValueOnApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
                Schema::table('applications', function (Blueprint $table) {
            // Hapus kolom status lama (hati-hati, data akan hilang jika tidak ditangani sebelumnya)
            $table->dropColumn('status');
        });
        Schema::table('applications', function (Blueprint $table) {
                    $table->enum('status', ['applied', 'processed', 'rejected', 'hired'])
                  ->default('applied')
                  ->after('applicant_profile_id'); // Ganti sesuai posisi yang kamu inginkan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('status');
        });

    }
}
