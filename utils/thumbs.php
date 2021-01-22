<?php

namespace Plugin\RatePage;

use is_numeric;
use is_string;

class ThumbRating
{
    public function getRating($data)
    {
        $rating = (isset($data['rating']) && !is_null($data['rating'])) ? $data['rating'] : false;

        if (!$rating) {
            return false;
        }

        // TODO Deprecated
        if ($rating === 'like-of') { // webmention twitter like
            return 1;
        }

        if (is_numeric($rating)) {
            if ($rating > 0) {
                return 1;
            } else {
                return -1;
            }
        }

        return 0;
    }

    public function targetExists($targetPage)
    {
        if (is_null($targetPage)) {
            return false;
        }

        return true;
    }

    public function isValidRating($rating)
    {
        return ($rating === 1 || $rating === -1);
    }

    public function getPrevRating($data)
    {
        return (isset($data['prevRating']) && !is_null($data['prevRating'])) ? $data['prevRating'] : null;
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
        $rating = $this->getRating($data);
        $prevRating = $this->getPrevRating($data);

        if (!$rating || !$this->isValidRating($rating)) {
            return 'failed';
        }

        if (isset($data['slug']) && is_string($data['slug'])) {
            $targetPage = page($data['slug']);
        } else {
            $targetPage = $data['targetPage'];
        }

        if (!$this->targetExists($targetPage)) {
            return 'failed';
        }

        $this->writeRating($rating, $prevRating, $targetPage);

        return 'thank you!';
    }
}
