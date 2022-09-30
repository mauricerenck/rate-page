<?php

namespace mauricerenck\RatePage;

return [
    'ratings' => function ($kirby) {
        return [
            'label' => 'Page Ratings',
            'icon' => 'star',
            'menu' => true,
            'link' => 'page-ratings',
            'views' => [
                [
                    'pattern' => 'page-ratings',
                    'action' => function () {
                        return [
                            'component' => 'k-page-ratings-view',
                            'title' => 'Page Ratings',
                            'props' => [
                                'ratingData' => function () {
                                    $utils = new RatingHelper();
                                    $top = $utils->getTopRatings();
                                    $worst = $utils->getWorstRatings();

                                    return ['top' => $top, 'worst' => $worst];
                                },
                                'startRatingData' => function () {
                                    $utils = new RatingHelper();
                                    $rating = $utils->getStarRatings();

                                    return $rating;
                                },
                                'version' => function () {
                                    $utils = new RatingHelper();
                                    $version = $utils->getPluginVersion();
                                    return $version;
                                }
                            ],
                        ];
                    }
                ]
            ]
        ];
    }
];
