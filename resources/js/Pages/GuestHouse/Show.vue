<script setup>

    import Layout from '../../shared/Layout.vue'
    import {defineProps, ref} from 'vue'

    const overlay = ref(false)
    const guesthouse = defineProps(['guesthouse', 'ratings', 'averageRating'])
    const rating = ref(4)
    const colors = ['red', 'orange', 'grey', 'cyan', 'green']
    const labels = ['bad', 'so so', 'ok', 'good', 'great']

    const imageLayout = [
    { cols: 4 },
    {
      cols: 8,
      children: [{ cols: 12 }, { cols: 12 }],
    },
    { cols: 6 },
    { cols: 3 },
    { cols: 9 },
    { cols: 4 },
    { cols: 8 },
  ]


</script>

<template>
        <Layout>

            <v-container>
                <v-row>
                    <v-col>
                        <h1>{{ guesthouse.guesthouse.room_name }}</h1>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="2"> <v-icon color="orange-lighten-2">mdi-star</v-icon> {{ guesthouse.averageRating }} reviews</v-col>
                    <v-col cols="5"> <v-icon color="red">mdi-map-marker</v-icon> Located in - {{ guesthouse.guesthouse.room_location }}</v-col>
                </v-row>
                <v-container>
                    <v-row>
                    <v-col cols="6" style="background-color: yellow;">
                        <v-img width="100%" height="100%" class="rounded-s-xl" src="https://media-cdn.tripadvisor.com/media/photo-s/06/24/3a/9e/jc-guesthouse.jpg">
                            <template v-slot:placeholder>
                                <div class="d-flex align-center justify-center fill-height">
                                    <v-progress-circular
                                    color="grey-lighten-4"
                                    indeterminate
                                    ></v-progress-circular>
                                </div>
                            </template>
                        </v-img>
                    </v-col>
                    <v-col cols="6">
                        <v-row>
                            <v-col cols="6">
                                <v-img cover src="https://media-cdn.tripadvisor.com/media/photo-s/06/24/3a/9e/jc-guesthouse.jpg">
                                    <template v-slot:placeholder>
                                        <div class="d-flex align-center justify-center fill-height">
                                            <v-progress-circular
                                            color="grey-lighten-4"
                                            indeterminate
                                            ></v-progress-circular>
                                        </div>
                                    </template>
                                </v-img>
                            </v-col>
                            <v-col cols="6">
                                <v-img cover class="rounded-te-xl" src="https://media-cdn.tripadvisor.com/media/photo-s/06/24/3a/9e/jc-guesthouse.jpg">
                                    <v-btn id="showAllBtn" @click="overlay = true" flat size="small" prepend-icon="mdi-image-multiple-outline" >show all images</v-btn>
                                    <template v-slot:placeholder>
                                        <div class="d-flex align-center justify-center fill-height">
                                            <v-progress-circular
                                            color="grey-lighten-4"
                                            indeterminate
                                            ></v-progress-circular>
                                        </div>
                                    </template>
                                </v-img>
                            </v-col>
                            <v-col cols="6">
                                <v-img cover src="https://media-cdn.tripadvisor.com/media/photo-s/06/24/3a/9e/jc-guesthouse.jpg">
                                    <template v-slot:placeholder>
                                        <div class="d-flex align-center justify-center fill-height">
                                            <v-progress-circular
                                            color="grey-lighten-4"
                                            indeterminate
                                            ></v-progress-circular>
                                        </div>
                                    </template>
                                </v-img>
                            </v-col>
                            <v-col cols="6" style="background-color: red;">
                                <v-img cover height="100%" class="rounded-be-xl ma-0" src="https://media-cdn.tripadvisor.com/media/photo-s/06/24/3a/9e/jc-guesthouse.jpg">
                                    <template v-slot:placeholder>
                                        <div class="d-flex align-center justify-center fill-height">
                                            <v-progress-circular
                                            color="grey-lighten-4"
                                            indeterminate
                                            ></v-progress-circular>
                                        </div>
                                    </template>
                                </v-img>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                </v-container>
                <v-divider/>
                <v-row>
                    <v-col cols="8">
                        <v-container>
                            <h2>About this place</h2>
                            <ul>
                                <li>{{ guesthouse.guesthouse.room_details }}</li>
                                <li>{{ guesthouse.guesthouse.room_location }}</li>
                            </ul>
                        </v-container>
                        <v-divider/>
                        <v-container>
                            <h2>Rate this place</h2>
                            <p style="color: gray">Tell others what you think.</p>
                            <div class="ms-3 mt-3">
                                <v-rating
                                v-model="rating"
                                :item-labels="labels"
                                hover
                                half-increments
                                color="orange-lighten-2"
                                >
                                <template v-slot:item-label="props">
                                    <span
                                    class="font-weight-black text-caption"
                                    :class="`text-${colors[props.index]}`"
                                    >
                                    {{ props.label }}
                                    </span>
                                </template>
                                </v-rating>
                            </div>
                        </v-container>
                        <v-divider/>
                        <v-container>
                                <h2>Ratings and reviews</h2>
                                <v-row>
                                    <v-col cols="6" v-for="n in 4" :key="n">
                                        <v-card>
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
                                                    color="orange-lighten-2"
                                                    class="ma-0"
                                                    >
                                                    </v-rating>
                                            </v-card-item>
                                            <v-card-item>
                                                <p>Lorem ipsum dolor sit amet.</p>
                                            </v-card-item>
                                        </v-card>
                                    </v-col>
                                </v-row>
                        </v-container>
                    </v-col>
                    <v-col cols="4" class="mt-3">
                        <v-hover
                            v-slot="{ isHovering, props }"
                            open-delay="200"
                        >
                        <v-card
                            :elevation="isHovering ? 16 : 2"
                            :class="{ 'on-hover': isHovering }"
                            v-bind="props"
                        >
                            <v-card-title>
                                <h2>Price Details</h2>
                            </v-card-title>
                            <v-card-item>
                                <v-row>
                                    <v-col>Monthly Fee</v-col>
                                    <v-col>P {{ guesthouse.guesthouse.room_price }}</v-col>
                                </v-row>
                            </v-card-item>
                            <v-card-item>
                                <v-btn color="green" width="100%">Reserve now</v-btn>
                            </v-card-item>
                        </v-card>
                        </v-hover>
                    </v-col>
                </v-row>
                <v-navigation-drawer
                    location="top"
                    temporary
                    height="100vh"
                    id="custom-drawer"
                >
                    <v-container>
                        <v-row justify="space-between">
                            <v-col>All Images</v-col>
                            <v-col><v-btn prepend-icon="mdi-close" @click="drawer = false">Close</v-btn></v-col>
                        </v-row>
                        <v-container>
                            <v-row>
                                <template v-for="(image,imgIdx) in imageLayout" :key="imgIdx">
                                <v-col :cols="image.cols">
                                    <v-img
                                    :src="`https://picsum.photos/500/300?image=${image.cols * 20}`"
                                    cover
                                    height="100%"
                                    >
                                        <template v-slot:placeholder>
                                            <div class="d-flex align-center justify-center fill-height">
                                                <v-progress-circular
                                                color="grey-lighten-4"
                                                indeterminate
                                                ></v-progress-circular>
                                            </div>
                                        </template>
                                    </v-img>
                                </v-col>

                                <v-col v-if="image.children" cols="6" class="d-flex flex-column">
                                    <v-row>
                                    <v-col v-for="(children,childIdx) in image.children" :key="childIdx" :cols="children.cols">
                                        <v-img
                                        :src="`https://picsum.photos/500/300?image=${children.cols + childIdx}`"
                                        cover
                                        height="100%"
                                        >
                                            <template v-slot:placeholder>
                                                <div class="d-flex align-center justify-center fill-height">
                                                    <v-progress-circular
                                                    color="grey-lighten-4"
                                                    indeterminate
                                                    ></v-progress-circular>
                                                </div>
                                            </template>
                                        </v-img>
                                    </v-col>
                                    </v-row>
                                </v-col>
                                </template>
                            </v-row>
                        </v-container>
                    </v-container>
                </v-navigation-drawer>  

            </v-container>

            <v-overlay v-model="overlay" width="100vw" height="100vh">

                <v-container class="bg-white overlay-container" width="100vw">
                        <v-row justify="space-between">
                            <v-col class="ms-5"><h1>All Images</h1></v-col>
                            <v-col class="justify-end d-flex me-5"><v-btn color="red" prepend-icon="mdi-close" @click="overlay = false">Close</v-btn></v-col>
                        </v-row>
                        <v-container>
                            <v-row>
                                <template v-for="(image,imgIdx) in imageLayout" :key="imgIdx">
                                <v-col :cols="image.cols">
                                    <v-img
                                    :src="`https://picsum.photos/500/300?image=${image.cols * 20}`"
                                    cover
                                    height="100%"
                                    ></v-img>
                                </v-col>

                                <v-col v-if="image.children" cols="6" class="d-flex flex-column">
                                    <v-row>
                                    <v-col v-for="(children,childIdx) in image.children" :key="childIdx" :cols="children.cols">
                                        <v-img
                                        :src="`https://picsum.photos/500/300?image=${children.cols + childIdx}`"
                                        cover
                                        height="100%"
                                        ></v-img>
                                    </v-col>
                                    </v-row>
                                </v-col>
                                </template>
                            </v-row>
                        </v-container>
                    </v-container>

            </v-overlay>

            
        </Layout>
        
</template>

<style scoped>

    #showAllBtn {
        right: 0; 
        margin-top: 5px; 
        margin-right: 10px; 
        position: absolute; 
        opacity: 0.8;
    }

    .overlay-container {
        max-height: 100vh;
        overflow-y: auto;
    }
    

</style>