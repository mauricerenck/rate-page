<?php

namespace mauricerenck\RatePage;

use is_numeric;
use is_string;
use Kirby\Data\yaml;
use \Exception;
use \Response;

class StarRating
{
    private $ratingHelper;

    public function __construct()
    {
        $this->ratingHelper = new RatingHelper();
    }

    public function writeRating($rating, $prevRating, $targetPage)
    {
        $kirby = kirby();
        kirby()->impersonate('kirby');

        $fieldData = $targetPage->ratingStar()->yaml();

        if (count($fieldData) === 0) {
            $fieldData = [
                'star1' => 0,
                'star2' => 0,
                'star3' => 0,
                'star4' => 0,
                'star5' => 0,
            ];
        }

        $fieldData['star' . $rating]++;

        if (!is_null($prevRating)) {
            $fieldData['star' . $prevRating]--;
        }

        $fieldDataString = yaml::encode($fieldData);

        $kirby = kirby();
        $kirby->impersonate('kirby');
        $targetPage->update([
            'ratingStar' => $fieldDataString
        ]);

        return $fieldData;
    }

    public function setRating($data)
    {
        $prevRating = $this->ratingHelper->getPrevRating($data);

        $rating = $this->ratingHelper->getRating($data);
        if ($rating['status'] === 'failed') {
            return new Response(json_encode($rating), 'application/json', 412);
        }

        $targetPage = $this->ratingHelper->getPageBySlug($data);
        if ($targetPage['status'] === 'failed') {
            return new Response(json_encode($targetPage), 'application/json', 404);
        }

        $ratings = $this->writeRating($rating['rating'], $prevRating, $targetPage['targetPage']);

        $response = [
            'status' => 'ok',
            'message' => 'Rating saved',
            'avgRating' => $this->getAvgRating($ratings)
        ];

        return new Response(json_encode($response), 'application/json', 201);
    }

    public function getAvgRating($ratings)
    {
        $stars = [];

        if (count($ratings) > 0) {
            $stars = [
                $ratings['star1'] * 1,
                $ratings['star2'] * 2,
                $ratings['star3'] * 3,
                $ratings['star4'] * 4,
                $ratings['star5'] * 5
            ];
        }

        $totalClicks = array_sum($ratings);
        $totalStars = array_sum($stars);

        $avgStars = ($totalStars > 0 && $totalClicks > 0) ? $totalStars / $totalClicks : 0;
        $avgStarsRounded = (round($avgStars * 4)) / 4;

        return $avgStarsRounded;
    }
}
