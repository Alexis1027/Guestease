<script setup>

    defineOptions({layout: GuestLayout})
    defineProps({ wishlists: Object })
    import {defineProps} from 'vue'
    import GuestLayout from '../../Layouts/GuestLayout.vue'

</script>

<template>
    <Head title="Wishlists" />
    <v-container>
        <p class="text-h4">Wishlists</p>
        <p class="mt-3 ms-3" v-if="wishlists.length <= 0">No wishlists found.</p>
        <v-row>
            <v-col cols="12" v-for="wishlist in wishlists" :key="wishlist.id">
                <v-hover v-slot="{ isHovering, props }">
                    <v-card id="wishlist" class="my-6"
                    :elevation="isHovering ? 12 : 1"
                    :class="{ 'on-hover': isHovering }"
                    v-bind="props">
                        <v-row>
                            <v-col cols="6" sm="6" md="4" lg="4" xl="4" xxl="4">
                                <v-card height="275">
                                    <v-carousel hide-delimiters height="100%" show-arrows="hover">
                                            <v-carousel-item v-for="(image, i) in JSON.parse(wishlist.listing.images)" :key="i">
                                                <Link :href="`room/${wishlist.listing.id}`">
                                                    <v-img :src="`/images/uploads/${image}`" cover height="100%"></v-img>
                                                </Link>
                                            </v-carousel-item>
                                    </v-carousel>
                                </v-card>
                            </v-col>
                            <v-col cols="6" sm="6" md="8" lg="8" xl="8" xxl="8">
                                <Link :href="`room/${wishlist.listing.id}`">
                                    <v-card-item class="text-h6">{{ wishlist.listing.title }}</v-card-item>
                                    <v-card-item>{{ wishlist.listing.description }}</v-card-item>
                                    <v-card-item>
                                        <v-icon color="red">mdi-map-marker</v-icon>
                                        {{ wishlist.listing.location }}
                                    </v-card-item>
                                    <v-card-item>
                                        <v-icon color="orange">mdi-star</v-icon>
                                        {{ wishlist.averageRating }} - ( {{ wishlist.totalRatings  }} {{ wishlist.totalRatings <= 1 ? 'rating' : 'ratings'}} )
                                    </v-card-item>
                                </Link>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-hover> 
            </v-col>
        </v-row>
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