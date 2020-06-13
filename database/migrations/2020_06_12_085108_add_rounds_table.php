<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoundsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->integer('round');
            $table->foreignId('game_id')->constrained();
            $table->dateTime('deadline');
            $table->dateTime('sent')->nullable();
            $table->timestamps();

            $table->unique([
                'round',
                'game_id'
            ]);
        });
        Schema::table('games', function (Blueprint $table) {
            $table->foreignId('current_round_id')
                ->nullable()
                ->references('id')
                ->on('rounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rounds');
    }
}
