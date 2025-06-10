<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIjazahEtcPathToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
            $table->string('pakelaring_path');
            $table->string('transkrip_path');
            $table->string('sertifikat_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        $table->dropColumn('pakelaring_path');
        $table->dropColumn('transkrip_path');
        $table->dropColumn('sertifikat_path');
        });
    }
}
