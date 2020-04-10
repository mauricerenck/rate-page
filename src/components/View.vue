<template>
    <k-view class="k-ratingviews-view">
        <k-header>Page Ratings</k-header>

        <k-column width="1/2">
            <PageRatings />
        </k-column>
    </k-view>
</template>

<script>
import PageRatings from './Ratings.vue'

export default {
    components: {
        PageRatings,
    },
}
</script>
