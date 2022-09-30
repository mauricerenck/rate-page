<template>
  <k-inside>
    <k-view class="k-page-ratings-view">
      <k-header>Page Ratings</k-header>
      <Version :version="version" />

      <RatingList
        :ratingData="sortedRatingData"
        :onChangeSorting="sortRatings"
        :currentSorting="currentSorting"
      />

      <StarRatingList :ratingData="startRatingData" />
    </k-view>
  </k-inside>
</template>

<script>
export default {
  props: {
    ratingData: Array,
    startRatingData: Array,
    version: Object,
  },
  data() {
    return {
      sortedRatingData: this.ratingData.top,
      sortedRatingTop: this.ratingData.top,
      sortedRatingWorst: this.ratingData.worst,
      currentSorting: "DESC",
    };
  },

  methods: {
    sortRatings(direction) {
      if (direction === "ASC") {
        this.sortedRatingData = this.sortedRatingWorst;
        this.currentSorting = "ASC";
      } else {
        this.sortedRatingData = this.sortedRatingTop;
        this.currentSorting = "DESC";
      }
    },
  },
};
</script>
<style lang="scss">
.k-page-ratings-view {
  table {
    width: 100%;
    border: 0;
    background: #fff;
    box-shadow: var(--box-shadow-item);
    margin-top: 2em;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  th {
    padding: 7px 5px;
    text-align: left;

    &.clickable {
      cursor: pointer;
    }

    &.active {
      text-decoration: underline;
    }
  }

  td {
    width: 10%;
    padding: 7px 5px;
  }

  td:first-child {
    width: 50%;
  }

  .starrating {
    margin-top: 40px;
  }
}
</style>
