<template>
    <div class="k-ratings">
        <k-list data-size="medium">
            <k-list-item
                v-for="rating in ratings"
                :key="rating.title"
                :link="rating.url"
                :info="`🙂 ${rating.up} &nbsp;&nbsp;&nbsp; 🙁 ${rating.down}`"
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
        }
    },
    created() {
        this.load()
    },
    methods: {
        load() {
            this.$api.get('ratepage/all').then(response => {
                this.ratings = response.ratings
                this.settings = response.settings
            })
        },
    },
}
</script>
