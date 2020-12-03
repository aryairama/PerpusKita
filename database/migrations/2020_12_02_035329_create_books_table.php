<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->string('id', 20);
            $table->string('title');
            $table->string('slug');
            $table->text('synopsis');
            $table->string('author');
            $table->string('publisher');
            $table->string('cover');
            $table->enum('status', ['ada','pinjam','hilang','rusak'])->default('ada');
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
        Schema::dropIfExists('books');
    }
}
