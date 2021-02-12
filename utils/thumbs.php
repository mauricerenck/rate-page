<?php

namespace mauricerenck\RatePage;

use is_numeric;
use is_string;
use \Response;

class ThumbRating
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

        if ($rating > 0) {
            if (!$targetPage->ratingThumbUp()->exists()) {
                $upValue = 1;
                $downValue = 0;
            } else {
                $upValue = $targetPage->ratingThumbUp()->value() + 1;
                $downValue = (!is_null($prevRating)) ? $targetPage->ratingThumbDown()->value() - 1 : $targetPage->ratingThumbDown()->value();
            }
        } else {
            if (!$targetPage->ratingThumbUp()->exists()) {
                $upValue = 0;
                $downValue = 1;
            } else {
                $upValue = (!is_null($prevRating)) ? $targetPage->ratingThumbUp()->value() - 1 : $targetPage->ratingThumbUp()->value();
                $downValue = $targetPage->ratingThumbDown()->value() + 1;
            }
        }

        $upValue = ($upValue < 0) ? 0 : $upValue;
        $downValue = ($downValue < 0) ? 0 : $downValue;

        $targetPage->update([
            'ratingThumbUp' => $upValue,
            'ratingThumbDown' => $downValue
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
