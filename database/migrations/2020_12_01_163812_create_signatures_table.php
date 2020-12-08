<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->index();
            $table->string('last_name')->index()->nullable();
            $table->string('type')->index();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('occupation_name')->nullable();
            $table->string('workplace_name')->nullable();
            $table->text('content')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('status')->index();
            $table->softDeletes();
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
        Schema::dropIfExists('signatures');
    }
}
