<?php

namespace mauricerenck\RatePage;

use is_numeric;
use is_string;
use f;
use Kirby\Http\Remote;

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

    public function getTopRatings()
    {
        $ratings = [];
        $collection = site()->index()->sortBy('ratingthumbup', 'desc')->limit(20);

        foreach ($collection as $item) {
            if ($item->ratingthumbup()->isNotEmpty() || $item->ratingthumbdown()->isNotEmpty()) {
                $ratings[] = [
                    'up' => $item->ratingthumbup()->value(),
                    'down' => $item->ratingthumbdown()->value(),
                    'title' => (string) $item->title(),
                    'url' => $item->panelUrl(),
                    'uid' => $item->uid()
                ];
            }
        }

        return $ratings;
    }

    public function getWorstRatings()
    {
        $ratings = [];
        $collection = site()->index()->sortBy('ratingthumbdown', 'desc')->limit(20);

        foreach ($collection as $item) {
            if ($item->ratingthumbup()->isNotEmpty() || $item->ratingthumbdown()->isNotEmpty()) {
                $ratings[] = [
                    'up' => $item->ratingthumbup()->value(),
                    'down' => $item->ratingthumbdown()->value(),
                    'title' => (string) $item->title(),
                    'url' => $item->panelUrl(),
                    'uid' => $item->uid()
                ];
            }
        }

        return $ratings;
    }

    public function getStarRatings()
    {
        $collection = site()->index();
        $ratingResults = [];

        foreach ($collection as $item) {
            if ($item->ratingStar()->isNotEmpty()) {
                $ratings = $item->ratingStar()->yaml();

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

                $ratingResults[] = [
                    'avg' => $avgStarsRounded,
                    'title' => (string) $item->title(),
                    'url' => $item->panelUrl(),
                    'uid' => $item->uid()
                ];
            }
        }
        rsort($ratingResults);

        return array_slice($ratingResults, 0, 20);
    }

    public function getPluginVersion()
    {
        try {
            $composerString = f::read(__DIR__ . '/../composer.json');
            $composerJson = json_decode($composerString);

            $packagistResult = Remote::get('https://repo.packagist.org/p2/mauricerenck/indieconnector.json');
            $packagistJson = json_decode($packagistResult->content());
            $latestVersion = $packagistJson->packages->{'mauricerenck/indieconnector'}[0]->version;

            return [
                'local' => $composerJson->version,
                'latest' => $latestVersion,
                'updateAvailable' => $composerJson->version !== $latestVersion,
                'error' => false
            ];
        } catch (Exception $e) {
            return [
                'local' => $composerJson->version,
                'latest' => 'unkown',
                'updateAvailable' => false,
                'error' => true
            ];
        }
    }
}
