<script setup>

    import {ref} from 'vue'
    import Map from './Partials/Map.vue'

    const step = ref(1)

</script>

<template>
    <v-card max-width="100vw" max-height="100vh" elevation="0">
  
        <v-window v-model="step">
            <v-window-item :value="1">
                <v-container id="step1">
                    <v-row>
                        <v-col cols="6" class="mt-6">
                            <p class="text-h5">Step 1 </p>
                            <p class="text-h3 my-2 mx-2">Tell us about your place</p>
                            <p>Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor sit amet, 
                                consectetur adipisicing elit. Corporis, sequi. adipisicing. 
                                Lorem ipsum dolor sit amet consectetur.</p>
                        </v-col>
                        <v-col cols="6">
                            <v-img cover height="100%" width="100%" src="../images/listing/Home-Interior-Design-PNG.png"></v-img>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>

            <v-window-item :value="2">
                <v-container id="step1">
                    <p class="text-center text-h4 mb-6">Where's your guest house located?</p>
                    <v-row justify="center">
                        <v-col cols="6" class="mt-5">
                            <v-text-field variant="solo" color="blue" label="Location" rounded="pill"></v-text-field>
                            <p class="text-end text-h6" id="location">Use my current location</p>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
            
            <v-window-item :value="3">
                <v-card-text>
                    <Map :latitude="10.257239" :longitude="123.959788" />
                </v-card-text>
            </v-window-item>

            <v-window-item :value="4">
                <v-container id="step1">
                    <p class="text-h4 my-3">Share some basics about your place</p>
                    <v-list>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus"></v-btn>
                                <span class="text-h6">0</span>
                                <v-btn flat class="mx-1" icon="mdi-plus"></v-btn>
                            </template>
                            <span class="text-h6">Guests</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus"></v-btn>
                                <span class="text-h6">0</span>
                                <v-btn flat class="mx-1" icon="mdi-plus"></v-btn>
                            </template>
                            <span class="text-h6">Bedrooms</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus"></v-btn>
                                <span class="text-h6">0</span>
                                <v-btn flat class="mx-1" icon="mdi-plus"></v-btn>
                            </template>
                            <span class="text-h6">Beds</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus"></v-btn>
                                <span class="text-h6">0</span>
                                <v-btn flat class="mx-1" icon="mdi-plus"></v-btn>
                            </template>
                            <span class="text-h6">Bathrooms</span>
                        </v-list-item>
                        <v-divider></v-divider>
                    </v-list>
                </v-container>
            </v-window-item>

            <v-window-item :value="5">
                <v-container id="step1">
                    <v-row>
                        <v-col cols="6" class="mt-6">
                            <p class="text-h5">Step 2</p>
                            <p class="text-h3 my-2 mx-2">Make your place stand out</p>
                            <p class="text-h6">Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor sit amet, 
                                consectetur adipisicing elit. Corporis, sequi. adipisicing. 
                                Lorem ipsum dolor sit amet consectetur.</p>
                        </v-col>
                        <v-col cols="6">
                            <v-img cover height="100%" width="100%" src="../images/listing/Home-Interior-Design-PNG.png"></v-img>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
  
            <v-window-item :value="6">
                <v-container class="placeoffers">
                    <p class="text-h4 my-6">What your place offers</p>
                    <v-row>
                        <v-col cols="4" v-for="n in 7" :key="n">
                            <v-card elevation="0" variant="outlined" class="rounded-xl" color="grey-lighten-1">
                                <v-card-item>
                                    <v-icon size="50" color="black">mdi-wifi</v-icon>
                                </v-card-item>
                                <v-card-text class="text-black text-h6">Wifi</v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>

            <v-window-item :value="7">
                <v-card-text>
                </v-card-text>
            </v-window-item>
        
      </v-window>
  
      <div id="action">
        <v-divider></v-divider>
      <v-progress-linear :model-value="step*10" color="blue-darken-3"></v-progress-linear>
  
        <v-card-actions>
            <v-btn v-if="step > 1" variant="text" @click="step--">
                Back
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn v-if="step < 10" color="blue-lighten-3" class="text-none" size="large" variant="flat" @click="step++">
                Next
            </v-btn>
        </v-card-actions>
      </div>
    </v-card>
  </template>

<style scoped>

  #location:hover {
    cursor: pointer;
  } 

  .placeoffers {
    width: 60%;
  }

  #step1 {
    margin-top: 10%;
    margin-bottom: 5%;
  }

  .v-window {
    height: 100vh;
  }

  #action {
    position: absolute;
    width: 100%;
    bottom: 0;
  }
</style>