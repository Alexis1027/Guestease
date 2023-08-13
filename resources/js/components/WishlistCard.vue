<template>
    <v-hover v-slot="{ isHovering, props }">
        <v-card id="wishlist" class="my-6"
        :elevation="isHovering ? 12 : 1"
        :class="{ 'on-hover': isHovering }"
        v-bind="props">
            <v-row>
                <v-col cols="4">
                    <v-card width="350">
                        <v-img src="images/room1.png"></v-img>
                    </v-card>
                </v-col>
                <v-col>
                    <v-card-item class="text-h6">Guest House </v-card-item>
                    <v-card-item>Lorem iasd asdasdas psum dolor sit amet consecasd asdtetur, adipas das aasd asd asdisicing elit. Asperiores, autem.</v-card-item>
                    <v-card-item>
                        <v-icon color="red">mdi-map-marker</v-icon>
                        Cebu - Cordova
                    </v-card-item>
                    <v-card-item>
                        <v-icon color="orange">mdi-star</v-icon>
                        4.00 - ( 4 ratings )
                    </v-card-item>
                </v-col>
            </v-row>
        </v-card>
    </v-hover>
</template>