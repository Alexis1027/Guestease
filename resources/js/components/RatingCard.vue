<script setup>

    import {ref} from 'vue'

    const star = ref(2)

</script>
<template>
    <v-hover v-slot="{ isHovering, props }">
        <v-card :elevation="isHovering ? 5 : 1" :class="{ 'on-hover': isHovering }" v-bind="props">
            <v-card-item>
                <v-avatar>
                    <v-img
                        src="https://i1.sndcdn.com/artworks-0EgHrWMz1UMPzydf-WDPNsg-t240x240.jpg"
                        alt="John"
                    ></v-img>
                </v-avatar>
                <strong> John Ambassing Doe</strong>
                <v-rating
                    half-increments
                    density="compact"
                    color="blue-lighten-2"
                    class="ma-0"
                    v-model="star"
                    readonly
                    >
                    </v-rating>
            </v-card-item>
            <v-card-item>
                <p>Lorem ipsum dolor sit amet.</p>
            </v-card-item>
        </v-card>
    </v-hover>
</template>