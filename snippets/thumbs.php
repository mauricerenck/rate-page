<?php
    if (!isset($slug)) {
        $slug = $page->uri();
    }

    $baseUrl = $kirby->url();
?>
<div class="rate-page__thumbs" data-slug="<?php echo $slug ?>" data-base-url="<?php echo $baseUrl ?>">
    <span><?php echo t('rating'); ?></span><br>
    <span class="thumb down" data-id="-1"><?php echo option('mauricerenck.ratePage.thumb-down-symbol'); ?> <span class="amount"><?php echo $page->ratingThumbDown()->or(0); ?></span></span>
    <span class="thumb up" data-id="1"><?php echo option('mauricerenck.ratePage.thumb-up-symbol'); ?> <span class="amount"><?php echo $page->ratingThumbUp()->or(0); ?></span></span>
</div>
<?php echo js([kirby()->url('media') . '/plugins/mauricerenck/ratePage/thumbs.js']); ?>