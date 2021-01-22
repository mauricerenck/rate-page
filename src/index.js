import View from "./components/View.vue";
import pageRatingField from "./components/fields/pageRating.vue";

panel.plugin("mauricerenck/ratePage", {
    views: {
        ratePage: {
            component: View,
            icon: "star",
            label: "Ratings"
        }
    },
    fields: {
        pageRating: pageRatingField
    }
});