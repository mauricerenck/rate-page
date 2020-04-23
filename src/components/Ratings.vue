<template>
  <div class="k-ratings">
    <k-list data-size="medium">
      <k-list-item
        v-for="rating in ratings"
        :key="rating.title"
        :link="rating.url"
        :info="`🙂 ${rating.up} (+${
          rating.up - rating.state.up
        }) &nbsp;&nbsp;&nbsp; 🙁 ${rating.down} (+${
          rating.down - rating.state.down
        })`"
        :text="`${rating.title}`"
        target="_self"
      />
    </k-list>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ratings: [],
      settings: [],
      ratingState: {
        up: 0,
        down: 0,
      },
    };
  },
  created() {
    this.load();
  },
  methods: {
    load() {
      const savedRatings = window.localStorage.getItem("k3-rate-page");
      this.savedRatings = !savedRatings ? [] : JSON.parse(savedRatings);

      this.$api.get("ratepage/all").then((response) => {
        response.ratings.forEach((rating) => {
          let newRating;
          const foundSavedRating = this.savedRatings.filter((savedRating) => {
            return savedRating.uid === rating.uid;
          })[0];

          if (!foundSavedRating) {
            newRating = rating;
          } else {
            foundSavedRating.state.up = foundSavedRating.up;
            foundSavedRating.state.down = foundSavedRating.down;

            newRating = { ...foundSavedRating, ...rating };

            console.log(newRating);
          }

          this.ratings.push(newRating);
        });

        this.settings = response.settings;
        window.localStorage.setItem(
          "k3-rate-page",
          JSON.stringify(this.ratings)
        );
      });
    },
  },
};
</script>
