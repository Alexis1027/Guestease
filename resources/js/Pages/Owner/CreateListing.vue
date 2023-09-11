<script setup>

    import {ref} from 'vue'
    import Map from './Partials/Map.vue'
    import {useForm} from '@inertiajs/vue3'
    import axios from 'axios'

    const step = ref(1)
    const price = ref(`P`+2500)

    const form = useForm({
        location: '',
        latitude: null,
        longitude: null,
        guests: 1,
        rooms: 1,
        bathrooms: 0,
        beds: 1
    })

    function getCoord() {
        axios.get(`https://nominatim.openstreetmap.org/search?q=${form.location}&format=json&limit=1`)
        .then(response => {
            form.latitude = response.data[0].lat
            form.longitude = response.data[0].lon
            form.location = response.data[0].display_name
            console.log(response)
        })
        .catch(err => {
            console.log(err)
        }) 
    }

    function getLocation() {
        navigator.geolocation.getCurrentPosition((pos) => {
        axios.get(`https://nominatim.openstreetmap.org/reverse?lat=${pos.coords.latitude}&lon=${pos.coords.longitude}&format=json&limit=1`)
        .then(response => {
            console.log(response)
            form.latitude = response.data.lat
            form.longitude = response.data.lon
            form.location = response.data.display_name
        })
        
        }, error => {
            console.log(error)
        })
    }

    function setPos(e) {
        form.latitude = latlng.lat
        form.longitude = latlng.lon
    }

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
                            <v-text-field variant="solo" v-model="form.location" color="blue" label="Location" @keydown.enter="getCoord()" rounded="pill"></v-text-field>
                            <p class="text-end text-h6" id="location" @click="getLocation()">Use my current location</p>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
            
            <v-window-item :value="3">
                <v-container>
                    <p class="text-h4">Is the pin in the right spot?</p>
                    <p class="text-h6 text-grey-darken">Click at the map to move the pin.</p>
                    <Map :latitude="form.latitude" :longitude="form.longitude" @setPos="setPos" />
                </v-container>
            </v-window-item>

            <v-window-item :value="4">
                <v-container id="step1">
                    <p class="text-h4 my-3">Share some basics about your place</p>
                    <v-list>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus" @click="form.guests--"></v-btn>
                                <span class="text-h6">{{ form.guests }}</span>
                                <v-btn flat class="mx-1" icon="mdi-plus" @click="form.guests++"></v-btn>
                            </template>
                            <span class="text-h6">Guests</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus" @click="form.rooms--"></v-btn>
                                <span class="text-h6">{{ form.rooms }}</span>
                                <v-btn flat class="mx-1" icon="mdi-plus" @click="form.rooms++"></v-btn>
                            </template>
                            <span class="text-h6">Rooms</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus" @click="form.beds--"></v-btn>
                                <span class="text-h6">{{ form.beds }}</span>
                                <v-btn flat class="mx-1" icon="mdi-plus" @click="form.beds++"></v-btn>
                            </template>
                            <span class="text-h6">Beds</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus" @click="form.bathrooms--"></v-btn>
                                <span class="text-h6">{{form.bathrooms}}</span>
                                <v-btn flat class="mx-1" icon="mdi-plus" @click="form.bathrooms++"></v-btn>
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
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 mt-6 text-start">Now, let's give your guesthouse a title</p>
                    <p class="text-h6 mb-6 text-grey-darken-2">Short titles work best. Have fun with it—you can always change it later.</p>
                    <v-textarea variant="outlined" counter="30">

                    </v-textarea>
                </v-container>
            </v-window-item>

            <v-window-item :value="8">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Next, let's describe your guesthouse</p>
                    <p class="text-start mb-5 text-grey-darken-1 text-h6">Choose up to 2 highlights. We'll use these to get your description started.</p>
                    <v-chip class="ma-2" size="x-large" prepend-icon="mdi-home-outline">
                        Stylish
                    </v-chip>
                    <v-chip class="ma-2" size="x-large" prepend-icon="mdi-leaf">
                        Peaceful
                    </v-chip>
                </v-container>
            </v-window-item>

            <v-window-item :value="9">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Create your description</p>
                    <p class="text-h6 mb-6 text-grey-darken-2 text-start">Share what makes your place special.</p>
                    <v-textarea variant="outlined" counter="255" placeholder="You'll have a great time at this comfortable place to stay.">

                    </v-textarea>
                </v-container>
            </v-window-item>

            <v-window-item :value="10">
                <v-container id="step1">
                    <v-row>
                        <v-col cols="6" class="mt-6">
                            <p class="text-h5">Step 3</p>
                            <p class="text-h3 my-2 mx-2">Finish up and publish</p>
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

            <v-window-item :value="11">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Now, set your price</p>
                    <p class="text-h6 mb-6 text-grey-darken-2 text-start">You can change it anytime.</p>
                    
                    <input type="text" style="width: 300px;" v-model="price" class="text-h1 ms-6">
                </v-container>
            </v-window-item>

            <v-window-item :value="12">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h3 text-start">Review your listing</p>
                    <p class="text-h6 mb-6 text-grey-darken-2 text-start">Here's what we'll show to guests. Make sure everything looks good.</p>
                    <v-row>
                        <v-col cols="5">
                            card or some shit
                        </v-col>
                        <v-col cols="7">
                            <p class="text-h5">What's next?</p>
                            <v-list>
                                <v-list-item>
                                    <template v-slot:prepend>
                                        <v-icon size="50">mdi-check-circle-outline</v-icon>
                                    </template>
                                    <v-list-item-title class="font-weight-bold">Confirm a few details and publish</v-list-item-title>

                                    <v-list-item-subtitle>
                                        We’ll let you know if you need to verify your
                                    </v-list-item-subtitle>
                                    <v-list-item-subtitle>
                                        identity or register with the local government.
                                    </v-list-item-subtitle>
                                </v-list-item>
                                <v-divider class="my-4" />
                                <v-list-item>
                                    <template v-slot:prepend>
                                        <v-icon size="50">mdi-pencil-outline</v-icon>
                                    </template>
                                    <v-list-item-title class="font-weight-bold">Adjust your settings</v-list-item-title>

                                    <v-list-item-subtitle>
                                        Set house rules, select a cancellation policy,
                                    </v-list-item-subtitle>
                                    <v-list-item-subtitle>
                                        choose how guests book, and more.
                                    </v-list-item-subtitle>
                                </v-list-item>
                            </v-list>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
        
      </v-window>
  
      <div id="action">
        <v-divider></v-divider>
      <v-progress-linear :model-value="(step/12)*100" color="blue-darken-3"></v-progress-linear>
  
        <v-card-actions>
            <v-btn v-if="step > 1" variant="text" @click="step--">
                Back
            </v-btn>
            <v-spacer></v-spacer>
            <Link href="/owner/dashboard" :disabled="step != 12">
                <v-btn v-if="step <= 12" color="blue-lighten-3" class="text-none" size="large" variant="flat" @click="step++">
                    {{ step < 12 ? 'Next' : 'Finish'}}
                </v-btn>
            </Link>
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