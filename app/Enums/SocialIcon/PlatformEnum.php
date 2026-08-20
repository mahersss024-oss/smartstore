<?php

namespace App\Enums\SocialIcon;

enum PlatformEnum: string
{
    case FACEBOOK = 'facebook';
    case INSTAGRAM = 'instagram';
    case TWITTER = 'twitter';
    case TIK_TOK = 'tik_tok';
    case YOUTUBE = 'youtube';
    case SNAPCHAT = 'snapchat';
    case EMAIL = 'email';
    case THREADS = 'threads';
    case WHATSAPP = 'whatsapp';
    case WHATSAPP_CHANNEL = 'whatsapp_channel';
    case AMAZON = 'amazon';
    case GOOGLE_PLAY_STORE = 'google_play_store';
    case APPLE_APP_STORE = 'apple_app_store';
    case APPLE_MUSIC = 'apple_music';
    case APPLE_PODCAST = 'apple_podcast';
    case DISCORD = 'discord';
    case GITHUB = 'github';
    case LINKEDIN = 'linkedin';
    case PATREON = 'patreon';
    case PHONE = 'phone';
    case PINTEREST = 'pinterest';
    case SIGNAL = 'signal';
    case SOUNDCLOUD = 'soundcloud';
    case SPOTIFY = 'spotify';
    case TELEGRAM = 'telegram';
    case TWITCH = 'twitch';

    public function label(): string
    {
        return match ($this) {
            self::FACEBOOK => 'Facebook',
            self::INSTAGRAM => 'Instagram',
            self::TWITTER => 'Twitter',
            self::TIK_TOK => 'TikTok',
            self::YOUTUBE => 'YouTube',
            self::SNAPCHAT => 'Snapchat',
            self::EMAIL => 'Email',
            self::THREADS => 'Threads',
            self::WHATSAPP => 'WhatsApp',
            self::WHATSAPP_CHANNEL => 'WhatsApp Channel',
            self::AMAZON => 'Amazon',
            self::GOOGLE_PLAY_STORE => 'Google Play Store',
            self::APPLE_APP_STORE => 'Apple App Store',
            self::APPLE_MUSIC => 'Apple Music',
            self::APPLE_PODCAST => 'Apple Podcast',
            self::DISCORD => 'Discord',
            self::GITHUB => 'GitHub',
            self::LINKEDIN => 'LinkedIn',
            self::PATREON => 'Patreon',
            self::PHONE => 'Phone',
            self::PINTEREST => 'Pinterest',
            self::SIGNAL => 'Signal',
            self::SOUNDCLOUD => 'SoundCloud',
            self::SPOTIFY => 'Spotify',
            self::TELEGRAM => 'Telegram',
            self::TWITCH => 'Twitch',
        };
    }

    public function example(): string
    {
        return match ($this) {
            self::FACEBOOK => 'https://www.facebook.com/yourprofile',
            self::INSTAGRAM => 'instagramusername',
            self::TWITTER => 'twitterhandle',
            self::TIK_TOK => 'tiktokusername',
            self::YOUTUBE => 'https://youtube.com/channel/youtubechannelurl',
            self::SNAPCHAT => 'https://www.snapchat.com/add/yourusername',
            self::EMAIL => 'youremail@address.com',
            self::THREADS => 'threadsusername',
            self::WHATSAPP => '+00000000000',
            self::WHATSAPP_CHANNEL => 'https://www.whatsapp.com/channel/yourchannel',
            self::AMAZON => 'https://amazon.com/shop/yourshop',
            self::GOOGLE_PLAY_STORE => 'https://play.google.com/store/apps/details?url=com.yourapp.app',
            self::APPLE_APP_STORE => 'https://apps.apple.com/us/yourapp/url1234567890',
            self::APPLE_MUSIC => 'https://music.apple.com/us/album/youralbum',
            self::APPLE_PODCAST => 'https://podcasts.apple.com/us/podcast/yourpodcast/123456789',
            self::DISCORD => 'https://discord.com/invite/yourchannel',
            self::GITHUB => 'https://www.github.com/username',
            self::LINKEDIN => 'https://linkedin.com/in/username',
            self::PATREON => 'https://patreon.com/',
            self::PHONE => '+1234567890',
            self::PINTEREST => 'https://pinterest.com/',
            self::SIGNAL => 'signal.me/#p/+1234567890',
            self::SOUNDCLOUD => 'https://soundcloud.com/username',
            self::SPOTIFY => 'https://open.spotify.com/artist/artistname',
            self::TELEGRAM => 'https://t.me/',
            self::TWITCH => 'https://twitch.tv/',
        };
    }

    public function prefix(): string
    {
        return match ($this) {
            self::FACEBOOK => 'https://www.facebook.com/',
            self::INSTAGRAM => 'https://www.instagram.com/',
            self::TWITTER => 'https://twitter.com/',
            self::TIK_TOK => 'https://www.tiktok.com/@',
            self::YOUTUBE => 'https://youtube.com/@',
            self::SNAPCHAT => 'https://www.snapchat.com/add/',
            self::EMAIL => 'mailto:',
            self::THREADS => 'https://threads.net/@',
            self::WHATSAPP => 'https://wa.me/',
            self::WHATSAPP_CHANNEL => '',
            self::AMAZON => '',
            self::GOOGLE_PLAY_STORE => '',
            self::APPLE_APP_STORE => '',
            self::APPLE_MUSIC => '',
            self::APPLE_PODCAST => '',
            self::DISCORD => '',
            self::GITHUB => 'https://github.com/',
            self::LINKEDIN => 'https://linkedin.com/in/',
            self::PATREON => 'https://patreon.com/',
            self::PHONE => 'tel:',
            self::PINTEREST => 'https://pinterest.com/',
            self::SIGNAL => '',
            self::SOUNDCLOUD => 'https://soundcloud.com/',
            self::SPOTIFY => '',
            self::TELEGRAM => 'https://t.me/',
            self::TWITCH => 'https://twitch.tv/',
        };
    }
}
