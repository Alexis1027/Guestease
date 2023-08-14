<script setup>

    import {ref, defineProps, defineEmits} from 'vue'
    import Reviews from '../components/MapSidebarReviews.vue'
    import Overview from '../components/MapSidebarOverview.vue'
    import Prices from '../components/MapSidebarPrices.vue'
    import About from '../components/MapSidebarAbout.vue'


    const props = defineProps(['mapSnackbar', 'guesthouse'])
    const tab = ref(null)
    const emit = defineEmits('closeMapSnackbar')

    const emitCloseMapSnackbar = () => {
        emit('closeMapSnackbar')
    }

</script>

<template>
    <v-snackbar
      v-model="props.mapSnackbar"
      location="right"
      transition="scroll-x-reverse-transition"
        color="white"
      >
    <Link :href="`/room/${props.guesthouse ? props.guesthouse.id : ''}`"><v-btn rounded color="green" id="reserveBtn" width="50%">Reserve now</v-btn></Link>

        <div class="custom-snackbar-content">

            <!-- <v-img cover src="/images/sheesh.png" width="100%">
                <v-btn
                @click="emitCloseMapSnackbar()"
                icon="mdi-close"
                id="closeBtn"
                size="small"
                >
                </v-btn>
            </v-img> -->

            <div style="height: 300px;">
                <v-carousel show-arrows="hover" height="100%">
                <v-carousel-item
                    src="/images/sheesh.png"
                    cover
                ></v-carousel-item>

                <v-carousel-item
                    src="/images/room1.png"
                    cover
                ></v-carousel-item>

                <v-carousel-item
                    src="/images/room2.png"
                    cover
                ></v-carousel-item>

                <v-btn
                @click="emitCloseMapSnackbar()"
                icon="mdi-close"
                id="closeBtn"
                size="small"
                >
                </v-btn>
            </v-carousel>
            </div>

            <v-card>
                <v-card-title>
                    <h3>
                        {{ props.guesthouse ? props.guesthouse.houseName : '' }}
                    </h3>
                </v-card-title>
                <v-tabs
                v-model="tab"
                bg-color="green-lighten-3"
                >
                    <v-tab value="overview">Overview</v-tab>
                    <v-tab value="prices">Price</v-tab>
                    <v-tab value="reviews">Reviews</v-tab>
                    <v-tab value="about">About</v-tab>
                </v-tabs>

                <v-card-text>
                    <v-window v-model="tab">
                        <v-window-item value="overview">
                            <Overview/>
                        </v-window-item>
                        <v-window-item value="prices">
                            <Prices/>
                        </v-window-item>
                        <v-window-item value="reviews">
                            <Reviews/>
                        </v-window-item>
                        <v-window-item value="about">
                            <About/>
                        </v-window-item>
                    </v-window>
                </v-card-text>

            </v-card>

        </div>

    </v-snackbar>
</template>

<style scoped>

    #closeBtn {
        right: 0;
        margin-right: 10px;
        margin-top: 10px;
        position: absolute;
    }

    .custom-snackbar-content {
        width: 35vw;
        max-width: 35vw; /* Set your desired max width */
        max-height: 80vh; /* Set your desired max height */
        overflow-y: auto; /* Add scrollbar when content overflows */
    }

    #reserveBtn {
        bottom: 0; 
        position: absolute; 
        z-index: 99; 
        right: 0; 
        margin-bottom: 20px;
        margin-right: 36px;
    }

</style>