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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_file_path')->nullable();
            $table->string('logo_name')->nullable();
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->text('location')->nullable();
            $table->text('cover_file_path')->nullable();
            $table->text('breadcrumb_file_path')->nullable();

            $table->json('times')->nullable();             // [{ working_time: '' }]
            $table->json('phone_numbers')->nullable();     // [{ phone: '' }]
            $table->json('emails')->nullable();            // [{ email: '' }]
            $table->json('timelines')->nullable();         // [{ year, timeline: '', short_description }]

            $table->string('slider_file_path')->nullable();
            $table->string('video_file_path')->nullable();
            $table->string('slider_small_title')->nullable();
            $table->string('slider_big_title')->nullable();
            $table->string('slider_text_color')->nullable();
            $table->string('slider_background_opacity')->nullable();
            $table->text('slider_small_short_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
