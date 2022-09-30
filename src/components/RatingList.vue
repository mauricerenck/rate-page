<template>
  <div>
    <k-headline>Thumb Ratings</k-headline>
    <table>
      <thead>
        <tr>
          <th>Page</th>
          <th
            v-on:click="onChangeSorting('DESC')"
            class="clickable"
            v-bind:class="{
              active: currentSorting === 'DESC',
            }"
          >
            Upvotes
          </th>
          <th
            v-on:click="onChangeSorting('ASC')"
            class="clickable"
            v-bind:class="{
              active: currentSorting === 'ASC',
            }"
          >
            Downvotes
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="rating in ratingData" :key="rating.title">
          <td>{{ rating.title }}</td>
          <td>🙂 {{ rating.up }}</td>
          <td>🙁 {{ rating.down }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    ratingData: Array,
    onChangeSorting: Function,
    currentSorting: String,
  },
};
</script>
