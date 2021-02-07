<?php
    if (!isset($slug)) {
        $slug = $page->url();
    }
?>
<div class="rate-page__thumbs">
    <span><?php echo t('rating'); ?></span><br>
    <span class="thumb down" data-id="-1" data-slug="<?php echo $slug ?>"><?php echo option('mauricerenck.ratePage.thumb-down-symbol'); ?> <span class="amount"><?php echo $page->ratingThumbDown()->or(0); ?></span></span>
    <span class="thumb up" data-id="1" data-slug="<?php echo $slug ?>"><?php echo option('mauricerenck.ratePage.thumb-up-symbol'); ?> <span class="amount"><?php echo $page->ratingThumbUp()->or(0); ?></span></span>
</div>
<?php echo js([kirby()->url('media') . '/plugins/mauricerenck/ratePage/thumbs.js']); ?>