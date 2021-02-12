<?php

namespace mauricerenck\RatePage;

use Kirby;

@include_once __DIR__ . '/vendor/autoload.php';
load([
    'Plugin\RatePage\RatingHelper' => 'utils/ratings.php',
    'Plugin\RatePage\ThumbRating' => 'utils/thumbs.php',
    'Plugin\RatePage\StarRating' => 'utils/stars.php',
], __DIR__);

Kirby::plugin('mauricerenck/ratePage', [
    'options' => require_once(__DIR__ . '/config/options.php'),
    'snippets' => [
        'thumb-rating' => __DIR__ . '/snippets/thumbs.php',
        'star-rating' => __DIR__ . '/snippets/stars.php',
    ],
    'api' => require_once(__DIR__ . '/config/api.php'),
    'hooks' => [
        'tratschtante.webhook.received' => function ($webmention, $targetPage) {
            if (!option('mauricerenck.ratePage.enable-webmention-support') || $webmention['type'] !== 'LIKE') {
                return;
            }

            $thumbRating = new ThumbRating();
            $data = [
                'rating' => 1,
                'prevRating' => null,
                'targetPage' => $targetPage
            ];
            return $thumbRating->setRating($data);
        }
    ],
    'routes' => [
        [
            'pattern' => 'ratepage/vote/(:any)',
            'action' => function ($voteType = 'thumb') {
                $data = kirby()->request()->data();

                if ($voteType === 'thumb') {
                    $thumbRating = new ThumbRating();
                    return $thumbRating->setRating($data);
                }

                if ($voteType === 'stars') {
                    $starRating = new StarRating();
                    return $starRating->setRating($data);
                }
            },
            'method' => 'POST'
        ],
    ],
    'fields' => [
        'pageRating' => []
    ]
]);
