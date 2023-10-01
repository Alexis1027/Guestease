<script setup>

    import {ref, watch} from 'vue'
    import Map from './Partials/Map.vue'
    import {useForm} from '@inertiajs/vue3'
    import axios from 'axios'

    const {auth} = defineProps(['auth'])
    const step = ref(1)

    const form = useForm({
        owner_id: auth.user.id,
        location: '',
        latitude: null,
        longitude: null,
        guests: 1,
        rooms: 1,
        bathrooms: 0,
        beds: 1,
        amenities: [],
        title: '',
        description: '',
        price: 2500,
        images: null,
        type: null
    })

    const imageRules = [
        value => {
            if(value.length >= 5) return true
            return `Images should have at least 5 images` 
        }
    ]

    const placeType = [
        {
            icon: 'mdi-home-outline',
            title: 'The entire place',
            subtitle: 'Guests have the whole place to themselves',
            value: 'entire place'
        },
        {
            icon: 'mdi-door-open',
            title: 'A room',
            subtitle: 'Guests have their own room in a guest house',
            value: 'room'
        }
    ]

    const placeOffers = [
        {
            icon: 'mdi-wifi',
            title: 'Wifi'            
        },
        {
            icon: 'mdi-television',
            title: 'Television'            
        },
        {
            icon: 'mdi-countertop-outline',
            title: 'Kitchen'            
        },
        {
            icon: 'mdi-fridge-outline',
            title: 'Fridge'            
        },
        {
            icon: 'mdi-dishwasher',
            title: 'Dishwasher'            
        },
        {
            icon: 'mdi-air-conditioner',
            title: 'Air conditioner'            
        },
        {
            icon: 'mdi-pool',
            title: 'Pool'            
        },
        {
            icon: 'mdi-hot-tub',
            title: 'Hot tub'            
        },
        {
            icon: 'mdi-grill-outline',
            title: 'BBQ grill'            
        },
    ]

    const loadingGetCoord = ref(false)
    function getCoord() {
        loadingGetCoord.value = true
        axios.get(`https://nominatim.openstreetmap.org/search?q=${form.location}&format=json&limit=1`)
        .then(response => {
            form.latitude = response.data[0].lat
            form.longitude = response.data[0].lon
            form.location = response.data[0].display_name
            console.log(response)
        loadingGetCoord.value = false
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
        console.log(e)
        form.latitude = e.latlng.lat
        form.longitude = e.latlng.lng
    }

    const submit = () => {
        form.post('/owner/createListing')
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
                            <v-text-field variant="solo" v-model="form.location" :loading="loadingGetCoord" color="blue" label="Location" @keydown.enter="getCoord()" rounded="pill"></v-text-field>
                            <p class="text-end text-blue-darken-4" id="location" @click="getLocation()">Use my current location</p>
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
                    <p class="text-h4">What type of place will guests have?</p>
                    {{ form }}
                    <v-item-group class="justify-center" selected-class="bg-blue-lighten-3">
                        <v-item v-slot="{  selectedClass, toggle }" class="mt-4" v-for="item in placeType" :key="item">
                            <v-card width="350" class="mt-5" @click="form.type = item.value">
                                <v-list-item :class="['d-flex align-center', selectedClass]" dark @click="toggle" :title="item.title" :subtitle="item.subtitle" :append-icon="item.icon"></v-list-item>
                            </v-card>
                        </v-item>
                    </v-item-group>
                </v-container>
            </v-window-item>

            <v-window-item :value="5">
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

            <v-window-item :value="6">
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
  
            <v-window-item :value="7">
                <v-container class="placeoffers">
                    <p class="text-h4 mt-6">What your place offers</p>
                    <p class="text-h6 mb-6 text-grey-darken">You can add more amenities after you publish your listing.</p>
                    <v-item-group multiple>
                        <v-container>
                            <v-row>
                                <v-col v-for="item in placeOffers" :key="item" cols="12" md="4" @click="form.amenities.push(item)">
                                    <v-item v-slot="{ isSelected, toggle }" >
                                        <v-card :color="isSelected ? 'blue-lighten-4' : ''" class="d-flex align-center" dark height="100" @click="toggle">
                                            <div class="text-h6 flex-grow-1 text-center">
                                                <v-icon size="50">{{ item.icon }}</v-icon>
                                                {{ item.title }}
                                            </div>
                                        </v-card>
                                    </v-item>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-item-group>
                </v-container>
            </v-window-item>

            <v-window-item :value="8">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 mt-6 text-start">Now, let's give your guest house a title</p>
                    <p class="text-h6 mb-6 text-grey-darken">Short titles work best. Have fun with it—you can always change it later.</p>
                    <v-textarea v-model="form.title" variant="outlined" counter="30">

                    </v-textarea>
                </v-container>
            </v-window-item>

            <v-window-item :value="9">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 mt-6 text-start">Add some photos of your guest house</p>
                    <p class="text-h6 mb-6 text-grey-darken">You'll need 5 photos to get started. You can add more or make changes later.</p>
                    <v-container>
                        <v-file-input
                                chips
                                variant="outlined"
                                prepend-inner-icon="mdi-image-outline"
                                v-model="form.images"
                                multiple
                                :rules="imageRules"
                                accept="image/png, image/jpeg"
                                name="room_image"
                                label="Images (minimum of 5 images)"
                                color="blue">
                                <template v-slot:selection="{ fileNames }">
                                    <template v-for="fileName in fileNames" :key="fileName">
                                        <v-chip size="small" label  color="blue" class="me-2">
                                        {{ fileName }}
                                        </v-chip>
                                    </template>
                                </template>
                            </v-file-input>
                    </v-container>
                </v-container>
            </v-window-item>

            <v-window-item :value="10">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Next, let's describe your guest house</p>
                    <p class="text-h6 mb-6 text-grey-darken text-start">Share what makes your place special.</p>
                    <v-textarea variant="outlined" v-model="form.description" counter="255" placeholder="You'll have a great time at this comfortable place to stay.">

                    </v-textarea>
                </v-container>
            </v-window-item>

            <v-window-item :value="11">
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

            <v-window-item :value="12">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Now, set your price</p>
                    <p class="text-h6 mb-6 text-grey-darken-2 text-start">You can change it anytime.</p>
                    
                    <input type="text" v-model="form.price" style="width: 300px;" class="text-h1 ms-6">
                </v-container>
            </v-window-item>

            <v-window-item :value="13">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h3 text-start">Review your listing</p>
                    <p class="text-h6 mb-6 text-grey-darken-2 text-start">Here's what we'll show to guests. Make sure everything looks good.</p>
                    <v-row>
                        <v-col cols="5">
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
      <v-progress-linear :model-value="(step/13)*100" color="blue-darken-3"></v-progress-linear>
  
        <v-card-actions>
            <v-btn v-if="step > 1" variant="text" @click="step--">
                Back
            </v-btn>
            <v-spacer></v-spacer>
                <v-btn v-if="step <= 12" color="blue-lighten-3" class="text-none" size="large" variant="flat" @click="step++">
                    Next
                </v-btn>
                <v-btn v-else type="submit" @click="submit" :disabled="form.processing" :loading="form.processing" color="blue-lighten-3" class="text-none" size="large" variant="flat">
                    Finish
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