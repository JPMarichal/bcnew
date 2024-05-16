<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Channel;
use App\Services\YoutubeService;

class ChannelSeeder extends Seeder
{
    public function run()
    {
        $youtubeService = new YoutubeService();
        $channelIds = [
            'UC-9GZ7QHKOmLS0APnfz2g1Q', 'UC3-nK6T9LpGw-_Sg5Qfxo9w', 'UC4N1XZRV9Jl5zxnVYZyQBVg',
            'UC5cnhB1_wyTsRCNoa7MejpQ', 'UC6WFrHobc4qhiXJzVOkRCZw', 'UC9BgT7CUr2KIgaLo45iNCbQ',
            'UCB2z2CvCfwmvSZV_viJIA3Q', 'UCbjTxzEvA_0KKehzYEIUIoQ', 'UCbKI2Le4gqATh18XFNfQI8A',
            'UCBt13kv4QFGQJ7P_6xp-nXQ', 'UCcKiVTW5AB-URN-WrsZ9wOQ', 'UCdmbSzE59B3hK-BugC0TsSg',
            'UCE4y2PnxjJYtSqlEEPuTG6w', 'UCfGqfO3jLF2HCRUzJw-G_cw', 'UCfnudJomMiqPZ12CO_8Eazg',
            'UCFUlCMNvrq1qB2XvnYk7SWw', 'UCGFPAlnTei9lYa_a0J_7WCw', 'UCHUlxF27ED56g36vEGwtygQ',
            'UCKb3VKCK6Fjq4-woVyzHoKg', 'UClhKkE_WcZLEwb8l5sgTv_w', 'UClMZ6ZcPXgvdds5-JG7gasQ',
            'UCMAN7yu5nT8NoUJnNn0VSyw', 'UCPRvAs7xLoU6Mza5fZ68lMg', 'UCPzuYg_EphUIYudeeLGhOVQ',
            'UCQ3qTh67Z-pQjjScF54jmLQ', 'UCrbpDZWGLN2GMgcFtTgi4Tg', 'UCRkedq-k2dAmb07iaPlctyg',
            'UCRkLXvhiRCeuRhVJWFuHuMg', 'UCsna10x6Sm-f_Yj6SxdALnQ', 'UCstxmex6TEoZgW0Gx410hHA',
            'UCt8BVvNuJ-OTzZBOkGVB-PQ', 'UCTa9pSb2iLBK_obQVwW3BAw', 'UCW3-DoWcoqzxpS1VccQGNUA',
            'UCWCpHqxpBcpnXiIiJOYgRYA', 'UCwL-OdWi61PR7pO1b70sI9w', 'UCWOffuPSEtx1siYJUTLy0gw',
            'UCXHGXHM0MVfNj4wgjTxMW-g', 'UCxrtj18r9Oibx6mYbZOYHXA', 'UCY5dEGAac6AIIB-z5U5E-9w',
            'UCyCSe8ZP4YRM7_zhY5pdu5A', 'UCystjoSabz96GptKTayd5Nw', 'UCYvHNsfw_MnhB9f_Bi2lJTQ'
        ];

        foreach ($channelIds as $channelId) {
            $channelDetails = $youtubeService->getChannelDetails($channelId);
            if ($channelDetails) {
                Channel::create([
                    'channel_id' => $channelId,
                    'title' => $channelDetails->getSnippet()->getTitle(),
                    'description' => $channelDetails->getSnippet()->getDescription(),
                    'language' => $channelDetails->getSnippet()->getDefaultLanguage() ?? 'es'
                ]);
            }
        }
    }
}
