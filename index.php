<?php

namespace Plugin\RatePage;

use Kirby;

@include_once __DIR__ . '/vendor/autoload.php';

load([
    'Plugin\RatePage\RatingHelper' => 'utils/ratings.php'
], __DIR__);

Kirby::plugin('mauricerenck/ratePage', [
    'options' => require_once(__DIR__ . '/config/options.php'),
    'snippets' => [
        'thumb-rating' => __DIR__ . '/snippets/thumbs.php',
    ],
    'api' => require_once(__DIR__ . '/config/api.php'),
    'hooks' => [
        'tratschtante.webhook.received' => function ($webmention, $targetPage) {
            if (!option('mauricerenck.ratePage.enable-webmention-support')) {
                return;
            }

            $ratingHelper = new RatingHelper();
            $data = [
                'rating' => 1,
                'prevRating' => null,
                'targetPage' => $targetPage
            ];
            return $ratingHelper->setRating($data);
        }
    ],
    'routes' => [
        [
            'pattern' => '(:all)/rate-page/thumb/(:any)',
            'action' => function () {
                $data = kirby()->request()->data();
                $ratingHelper = new RatingHelper();
                return $ratingHelper->setRating($data);
            },
            'method' => 'POST'
        ],
    ]
]);
