<script setup>

    import Prices from './MapSidebarPrices.vue'
    import Reviews from './MapSidebarReviews.vue'
    import About from './MapSidebarAbout.vue'

</script>

<template>
    <div>
        <About/>
        <v-divider class="my-4"/>
        <Prices/>
        <v-divider class="my-4"/>
        <Reviews/>
    </div>
</template>