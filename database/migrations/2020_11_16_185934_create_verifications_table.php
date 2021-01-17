<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->string('nim', 10)->primary();
            $table->string('pembayaran', 20);
            $table->string('lppm', 20);
            $table->string('perpus', 20);
            $table->enum('status_pembayaran', ['not uploaded', 'pending', 'approved', 'rejected']);
            $table->enum('status_lppm', ['not uploaded', 'pending', 'approved', 'rejected']);
            $table->enum('status_perpus', ['not uploaded', 'pending', 'approved', 'rejected']);
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
        Schema::dropIfExists('verifications');
    }
}
