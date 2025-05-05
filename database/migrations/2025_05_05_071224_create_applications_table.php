<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_id');
            $table->uuid('applicant_profile_id');
            $table->enum('status', ['applied', 'interview', 'hired', 'rejected'])->default('applied');
            $table->timestamps();
    
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreign('applicant_profile_id')->references('id')->on('applicant_profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
