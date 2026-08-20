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
        Schema::create('social_icons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('platform', [
                'facebook',
                'instagram',
                'twitter',
                'tik_tok',
                'youtube',
                'snapchat',
                'email',
                'threads',
                'whatsapp',
                'whatsapp_channel',
                'amazon',
                'google_play_store',
                'apple_app_store',
                'apple_music',
                'apple_podcast',
                'discord',
                'github',
                'linkedin',
                'patreon',
                'phone',
                'pinterest',
                'signal',
                'soundcloud',
                'spotify',
                'telegram',
                'twitch',
                'personal_website',
            ]);
            $table->string('url');
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_icons');
    }
};
