<?php

namespace mauricerenck\RatePage;

use is_numeric;
use is_string;

class RatingHelper
{
    public function getRating($data)
    {
        if (isset($data['rating']) && !is_null($data['rating']) && is_numeric($data['rating'])) {
            if (intval($data['rating']) > 0 || intval($data['rating']) === -1) {
                return [
                    'status' => 'success',
                    'rating' => $data['rating']
                ];
            }
        }

        return [
            'status' => 'failed',
            'message' => 'Invalid rating',
        ];
    }

    public function getPrevRating($data)
    {
        return (isset($data['prevRating']) && !is_null($data['prevRating'])) ? $data['prevRating'] : null;
    }

    public function getPageBySlug($data)
    {
        if (isset($data['slug']) && is_string($data['slug'])) {
            $targetPage = [
                'status' => 'success',
                'targetPage' => page($data['slug'])
            ];
        } else {
            $targetPage = [
                'status' => 'success',
                'targetPage' => $data['targetPage']
            ];
        }

        if (is_null($targetPage['targetPage'])) {
            return [
                'status' => 'failed',
                'message' => 'Target not found',
            ];
        }

        return $targetPage;
    }
}
