<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEducationUuidToApplicantProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_profiles', function (Blueprint $table) {
            $table->uuid('education_uuid')->nullable()->change();  // Make it nullable
            $table->foreign('education_uuid')->references('id')->on('educations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_profiles', function (Blueprint $table) {
            $table->dropForeign(['education_uuid']);
            $table->dropColumn('education_uuid');
        });
    }
}
