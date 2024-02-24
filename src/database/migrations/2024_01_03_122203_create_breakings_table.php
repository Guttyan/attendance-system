<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreakingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakings', function (Blueprint $table) {
            $table->id();
            $table->foreignID('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignID('work_id')->constrained('works')->cascadeOnDelete();
            $table->text('start_time');
            $table->text('end_time')->nullable();
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
        Schema::dropIfExists('breakings');
    }
}
