<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('full_name');
            $table->string('surname');
            $table->string('ktp_number')->unique();
            $table->text('address');
            $table->string('phone_number')->unique();
            $table->string('photo_path')->nullable();
            $table->string('instagram_surname')->nullable();
            $table->string('linkedin_surname')->nullable();
            $table->uuid('education_uuid');
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
        Schema::dropIfExists('applicant_profiles');
    }
}
