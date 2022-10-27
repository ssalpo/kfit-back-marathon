<?php

namespace Tests\Helpers;

use Illuminate\Support\Facades\Http;

class BroadcastLiveFakeHelper
{
    public static function initServicesFakeData()
    {
        self::kinescopeLive();
    }

    public static function kinescopeLive()
    {
        $data = [
            "data" => [
                "id" => "341ea4ec-0248-4047-86b3-cf6ce34a1a0f",
                "name" => "Test livastream",
                "type" => "one-time",
                "streamkey" => "28dbebe1c6064fb499ec8dc30249325d",
                "save_stream" => false,
                "auto_start" => false,
                "protected" => false,
                "dvr" => true,
                "video_id" => "fac69e20-93ed-495d-a2fa-44fd1324576d",
                "folder_id" => null,
                "created_at" => "2022-10-25T04:07:17.127794Z",
                "updated_at" => null,
                "play_link" => "https://kinescope.io/202083609",
                "rtmp_url" => "rtmp://rtmp.kinescope.io/live",
                "chat_link" => "",
                "stream" => [],
                "reconnect_window" => 1800,
                "scheduled" => true,
                "thumbs" => false,
                "presets" => [],
                "restream_urls" => [],
            ]
        ];

        Http::fake([
            config('services.kinescope.url') . '/live/events' => Http::response($data)
        ]);

        return $data;
    }
}
