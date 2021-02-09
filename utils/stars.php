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

    public function getRating($data)
    {
        $rating = (isset($data['rating']) && !is_null($data['rating'])) ? $data['rating'] : false;

        if (!$rating) {
            return false;
        }

        if (is_numeric($rating)) {
            return $rating;
        }

        return false;
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
        $rating = $this->getRating($data);
        $prevRating = $this->ratingHelper->getPrevRating($data);

        if (!$rating || !$this->ratingHelper->isValidRating($rating)) {
            $response = [
                'status' => 'failed',
                'message' => 'Invalid field values',
            ];

            return new Response(json_encode($response), 'application/json', 412);
        }

        if (isset($data['slug']) && is_string($data['slug'])) {
            $targetPage = page(str_replace(site()->url(), '', $data['slug']));
        } else {
            $targetPage = $data['targetPage'];
        }

        if (!$this->ratingHelper->targetExists($targetPage)) {
            $response = [
                'status' => 'failed',
                'message' => 'Target not found',
            ];

            return new Response(json_encode($response), 'application/json', 404);
        }

        $this->writeRating($rating, $prevRating, $targetPage);

        $response = [
            'status' => 'ok',
            'message' => 'Rating saved',
        ];

        return new Response(json_encode($response), 'application/json', 201);
    }
}
