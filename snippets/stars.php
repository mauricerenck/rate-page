<?php
    if (!isset($slug)) {
        $slug = $page->uri();
    }

    $baseUrl = $kirby->url();

    $ratings = $page->ratingStar()->yaml();
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
?>
<div class="rate-page__stars"  data-slug="<?php echo $slug ?>" data-base-url="<?php echo $baseUrl ?>">
    <span><?php echo t('rating'); ?></span><br>

    <?php
        $rest = $avgStarsRounded - floor($avgStarsRounded);
        switch ($rest) {
            case 0.25: $additionalClassName = 'fquarter'; break;
            case 0.5: $additionalClassName = 'half'; break;
            case 0.75: $additionalClassName = 'lquarter'; break;
            default: $additionalClassName = ''; break;
        }
    ?>
    <div class="rating">
        <?php for ($i = 5; $i >= 1; $i--) : ?>
            <?php $className = ($i <= $avgStarsRounded) ? 'checked ' : '' ?>
            <?php $className = ($i > $avgStarsRounded && $i - 1 < $avgStarsRounded) ? 'checked ' . $additionalClassName : $className ?>

            <span class="star <?php echo $className; ?>" data-id="<?php echo $i; ?>"><?php echo option('mauricerenck.ratePage.stars.symbol-empty');?></span>
        <?php endfor; ?>
    </div>
    <?php if (option('mauricerenck.ratePage.stars.showAvg', true)):?>
        <span class="sum"><?php echo $avgStarsRounded; ?></span>
    <?php endif; ?>
</div>
<?php echo js([kirby()->url('media') . '/plugins/mauricerenck/ratePage/stars.js']); ?>
