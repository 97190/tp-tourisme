<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('body');
            $table->string('photoArticle')->nullable();
            $table->string("image_path")->nullable(false);
            $table->unsignedBigInteger("user_id")->nullable(false);
            $table->foreign('user_id')->references("id")->on("users")->onDelete("cascade");
            $table->unsignedBigInteger("loisir_id")->nullable(false);
            $table->foreign('loisir_id')->references("id")->on("loisirs")->onDelete("cascade");
            $table->unsignedBigInteger("theme_id")->nullable(false);
            $table->foreign('theme_id')->references("id")->on("themes")->onDelete("cascade");
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
        Schema::dropIfExists('articles');
    }
};
