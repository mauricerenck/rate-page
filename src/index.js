import RatingsView from "./components/View.vue";
import RatingList from "./components/RatingList.vue"
import StarRatingList from "./components/StarRatingList.vue"
import Version from "./components/Version.vue"

panel.plugin("mauricerenck/ratePage", {
    components: {
        'k-page-ratings-view': RatingsView,
        'RatingList': RatingList,
        'StarRatingList': StarRatingList,
        'Version': Version,
    }
});