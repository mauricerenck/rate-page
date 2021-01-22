<template>
  <ul class="k-ratepage-list">
    <li v-for="(item, index) in paginatedItems" :key="index">up {{item}}</li>
  </ul>
</template>

<script>
export default {
  props: {
    value: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  data() {
    console.log(this.value);

    return {
      items: this.makeItems(this.value)
    };
  },
  methods: {
    makeItems(value) {
      if (Array.isArray(value) === false) {
        return [];
      }
      return this.sort(value);
    }
  }
};
</script>

<style>
.k-ratepage-list {
  background: #fff;
}
</style>