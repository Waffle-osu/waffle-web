<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ww_site_tokens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id");
            $table->string("token")->index("ID_token");
            //For when you check the save box
            $table->boolean("save_login");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ww_site_tokens');
    }
};
