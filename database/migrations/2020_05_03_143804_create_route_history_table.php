<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('route_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('method');
            $table->string('domain')->nullable();
            $table->string('uri');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('route_history');
    }
}
