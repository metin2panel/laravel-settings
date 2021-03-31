<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    protected $tablename;

    protected $keyColumn;

    protected $valueColumn;

    public function __construct()
    {
        $this->connection = config('laravel-settings.connection');
        $this->tablename = config('laravel-settings.table');
        $this->keyColumn = config('laravel-settings.key_column');
        $this->valueColumn = config('laravel-settings.value_column');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tablename, function (Blueprint $table) {
            $table->increments('Id');
            $table->string($this->keyColumn)->index();
            $table->text($this->valueColumn);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->tablename);
    }
}
