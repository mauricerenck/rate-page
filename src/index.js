import View from "./components/View.vue";

panel.plugin("mauricerenck/ratePage", {
    views: {
        ratePage: {
            component: View,
            icon: "star",
            label: "Ratings"
        }
    }
});