<script setup>

    import Layout from '../shared/Layout.vue'
    import WishlistCard from '../components/WishlistCard.vue'

</script>

<template>
    <Layout>
        <v-container>
            <p class="text-h4">Wishlists</p>
            <template v-for="n in 5" :key="n">
                <Link :href="`/room/${n}`">
                    <WishlistCard/>
                </Link>
            </template>
        </v-container>
    </Layout>
</template>

<style scoped>

    #wishlist:hover {
        cursor: pointer;
    }

    #wishlist {
        text-decoration: none;
    }

</style>