<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeRunTimeInteger extends Migration
{
    public function up()
    {
        DB::table('route_history')->update([
            'run_time' => null,
        ]);

        Schema::table('route_history', function (Blueprint $table) {
            $table->integer('run_time')->nullable()->change();
        });
    }
}
