<script setup>

    import {defineProps} from 'vue'
    const prop = defineProps(['wishlist'])
    const images = []
    const guestHouseImg = prop.wishlist.guesthouse.images.split(",")
    guestHouseImg.forEach(img => {
        images.push(img)
    });
</script>


<template>
    <v-hover v-slot="{ isHovering, props }">
        <v-card id="wishlist" class="my-6"
        :elevation="isHovering ? 12 : 1"
        :class="{ 'on-hover': isHovering }"
        v-bind="props">
            <v-row>
                <v-col cols="4">
                    <v-card height="275">
                        <v-carousel hide-delimiters height="100%" show-arrows="hover">
                            
                                <v-carousel-item v-for="(image, i) in images" :key="i">
                                    <Link :href="`room/${prop.wishlist.guesthouse.id}`">
                                        <v-img :src="`images/${image}`" cover height="100%"></v-img>
                                    </Link>
                                </v-carousel-item>
                            
                        </v-carousel>
                    </v-card>
                </v-col>
                <v-col>
                    <Link :href="`room/${prop.wishlist.guesthouse.id}`">
                        <v-card-item class="text-h6">{{ prop.wishlist.guesthouse.title }}</v-card-item>
                        <v-card-item>{{ prop.wishlist.guesthouse.description }}</v-card-item>
                        <v-card-item>
                            <v-icon color="red">mdi-map-marker</v-icon>
                            {{ prop.wishlist.guesthouse.location }}
                        </v-card-item>
                        <v-card-item>
                            <v-icon color="orange">mdi-star</v-icon>
                            {{ prop.wishlist.averageRating }} - ( {{ prop.wishlist.totalRatings  }} {{ prop.wishlist.totalRatings <= 1 ? 'rating' : 'ratings'}} )
                        </v-card-item>
                    </Link>
                </v-col>
            </v-row>
        </v-card>
    </v-hover>
</template>