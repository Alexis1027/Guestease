<script setup>

    import {defineProps} from 'vue'
    import Layout from '../shared/Layout.vue'
    import WishlistCard from '../components/WishlistCard.vue'
    defineOptions({layout: Layout})
    const props = defineProps(['wishlists'])

</script>

<template>
    <Head title="Wishlist" />
    <p class="text-h4">Wishlists</p>
    <template v-for="wishlist in props.wishlists" :key="wishlist.id">
        <!-- <Link :href="`/room/${n}`"> -->
            <WishlistCard :wishlist="wishlist"/>
        <!-- </Link> -->
    </template>
</template>

<style scoped>

    #wishlist:hover {
        cursor: pointer;
    }

    #wishlist {
        text-decoration: none;
    }

</style>