<?php

namespace mauricerenck\RatePage;

use is_numeric;
use is_string;

class RatingHelper
{
    public function targetExists($targetPage)
    {
        if (is_null($targetPage)) {
            return false;
        }

        return true;
    }

    public function isValidRating($rating)
    {
        return ($rating > 0 || $rating === -1);
    }

    public function getPrevRating($data)
    {
        return (isset($data['prevRating']) && !is_null($data['prevRating'])) ? $data['prevRating'] : null;
    }
}
