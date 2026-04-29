<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('exams', function (Blueprint $table) {
        if (!Schema::hasColumn('exams', 'max_strikes')) {
            $table->integer('max_strikes')->default(3);
        }
    });
}

public function down()
{
    Schema::table('exams', function (Blueprint $table) {
        $table->dropColumn('max_strikes');
    });
}
};
