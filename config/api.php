<?php

namespace Plugin\RatePage;

use json_encode;

return [
    'routes' => [
        [
            'pattern' => 'ratepage/all',
            'action' => function () {
                $ratings = [];
                $settings = [
                    'upSymbol' => option('mauricerenck.ratePage.thumb-up-symbol'),
                    'downSymbol' => option('mauricerenck.ratePage.thumb-down-symbol'),
                ];
                $collection = site()->index()->sortBy('ratingthumbup', 'desc');

                foreach ($collection as $item) {
                    if ($item->ratingthumbup()->isNotEmpty() || $item->ratingthumbdown()->isNotEmpty()) {
                        $ratings[] = [
                            'up' => $item->ratingthumbup()->value(),
                            'down' => $item->ratingthumbdown()->value(),
                            'title' => (string) $item->title(),
                            'url' => $item->panelUrl(),
                        ];
                    }
                }

                return json_encode(['settings' => $settings, 'ratings' => $ratings]);
            }
        ],
    ]
];
