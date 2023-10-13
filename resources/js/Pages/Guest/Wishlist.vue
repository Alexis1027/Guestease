<script setup>

    import {defineProps} from 'vue'
    import Layout from '../../Layouts/GuestLayout.vue'
    import WishlistCard from './Partials/WishlistCard.vue'
    
    defineOptions({layout: Layout})
    defineProps({
        wishlists: Object
    })

</script>

<template>
    <Head title="Wishlists" />
    <p class="text-h4">Wishlists</p>
    <p class="mt-3 ms-3" v-if="wishlists.length <= 0">No wishlists found.</p>

    <template v-for="wishlist in wishlists" :key="wishlist.id">
            <WishlistCard v-if="wishlist.listing" :wishlist="wishlist"/>
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