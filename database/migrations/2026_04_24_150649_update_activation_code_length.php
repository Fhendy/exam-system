<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activation_codes', function (Blueprint $table) {
            $table->string('code', 10)->change(); // Ubah dari 8 ke 10 atau biarkan
        });
    }

    public function down()
    {
        Schema::table('activation_codes', function (Blueprint $table) {
            $table->string('code', 20)->change();
        });
    }
};