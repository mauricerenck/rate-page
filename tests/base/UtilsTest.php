<?php
use mauricerenck\RatePage\RatingHelper;
use PHPUnit\Framework\TestCase;
use Kirby\Cms;

final class UtilsTest extends TestCase
{
    public function testShouldGetPositiveRating()
    {
        $ratingHelper = new RatingHelper();
        $data = [
            'rating' => 1,
            'prevRating' => null,
            'targetPage' => ''
        ];

        $this->assertEquals(1, $ratingHelper->getRating($data));
    }

    public function testShouldGetNegativeRating()
    {
        $ratingHelper = new RatingHelper();
        $data = [
            'rating' => -1,
            'prevRating' => null,
            'targetPage' => ''
        ];

        $this->assertEquals(-1, $ratingHelper->getRating($data));
    }

    public function testShouldGetNeutralRating()
    {
        $ratingHelper = new RatingHelper();
        $data = [
            'rating' => 'bogus',
            'prevRating' => null,
            'targetPage' => ''
        ];

        $this->assertEquals(0, $ratingHelper->getRating($data));
    }

    public function testShouldGetPreviousRating()
    {
        $ratingHelper = new RatingHelper();
        $data = [
            'rating' => 'bogus',
            'prevRating' => 1,
            'targetPage' => ''
        ];

        $this->assertEquals(1, $ratingHelper->getPrevRating($data));
    }

    public function testShouldGetUnsetPreviousRating()
    {
        $ratingHelper = new RatingHelper();
        $data = [
            'rating' => 'bogus',
            'prevRating' => null,
            'targetPage' => ''
        ];

        $this->assertEquals(null, $ratingHelper->getPrevRating($data));
    }

    public function testShouldCheckForTargetValue()
    {
        $ratingHelper = new RatingHelper();
        $this->assertEquals(false, $ratingHelper->targetExists(null));
        $this->assertEquals(true, $ratingHelper->targetExists('page'));
    }

    public function testShouldCheckForValidRating()
    {
        $ratingHelper = new RatingHelper();
        $this->assertEquals(true, $ratingHelper->isValidRating(1));
        $this->assertEquals(true, $ratingHelper->isValidRating(-1));
        $this->assertEquals(false, $ratingHelper->isValidRating(3));
    }

    public function testShouldWriteRating()
    {
        $targetPageMock = $this->getMockBuilder(Page::class)
            ->enableProxyingToOriginalMethods()
            ->getMock();
        ;

        $data = [
            'rating' => 'bogus',
            'prevRating' => null,
            'targetPage' => ''
        ];

        $ratingHelper = new RatingHelper();
        $ratingHelper->writeRating(1, 0, '/home');

        $targetPageMock->expects($this->exactly(3))
            ->method('update');

        // $this->assertEquals(true, $targetPageMock);
        // TODO
    }
}
