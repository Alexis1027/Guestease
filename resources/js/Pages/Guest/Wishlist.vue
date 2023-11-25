<script setup>

    import {defineProps} from 'vue'
    import GuestLayout from '../../Layouts/GuestLayout.vue'
    import WishlistCard from './Partials/WishlistCard.vue'
    
    defineOptions({layout: GuestLayout})
    defineProps({
        wishlists: Object
    })

</script>

<template>
    <Head title="Wishlists" />
    <v-container>
        <p class="text-h4">Wishlists</p>
        <p class="mt-3 ms-3" v-if="wishlists.length <= 0">No wishlists found.</p>
        <template v-for="wishlist in wishlists" :key="wishlist.id">
                <WishlistCard v-if="wishlist.listing" :wishlist="wishlist"/>
        </template>
    </v-container>
</template>

<style scoped>

    #wishlist:hover {
        cursor: pointer;
    }

    #wishlist {
        text-decoration: none;
    }

</style>