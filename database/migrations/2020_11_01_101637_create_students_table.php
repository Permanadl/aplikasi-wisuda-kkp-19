<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->string('nim', 10)->primary();
            $table->string('nama_mhs', 50);
            $table->enum('jk', ['L', 'P']);
            $table->string('tempat_lahir', 20)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('id_prodi', 5);
            $table->year('tahun');
            $table->string('email', 100)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->string('photo', 100)->nullable();
            $table->unsignedDecimal('ipk', 3, 2);
            $table->mediumText('judul_skripsi');
            $table->text('password');
            $table->timestamp('last_login')->nullable();
            $table->enum('edited', ['not yet', 'edited'])->default('not yet');
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
        Schema::dropIfExists('students');
    }
}
