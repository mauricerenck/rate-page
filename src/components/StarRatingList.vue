<template>
  <div class="starrating">
    <k-headline>Star Ratings</k-headline>
    <table>
      <thead>
        <tr>
          <th>Page</th>
          <th>Avg Rating</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="rating in ratingData" :key="rating.title">
          <td>{{ rating.title }}</td>
          <td>{{ rating.avg }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: {
    ratingData: Array,
  },
};
</script>
