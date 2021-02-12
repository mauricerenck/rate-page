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

        $fieldData = yaml::encode($fieldData);

        $kirby = kirby();
        $kirby->impersonate('kirby');
        $targetPage->update([
            'ratingStar' => $fieldData
        ]);
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

        $this->writeRating($rating['rating'], $prevRating, $targetPage['targetPage']);

        $response = [
            'status' => 'ok',
            'message' => 'Rating saved',
        ];

        return new Response(json_encode($response), 'application/json', 201);
    }
}
