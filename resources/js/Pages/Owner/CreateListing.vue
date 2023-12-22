<script setup>

    import {ref, watch} from 'vue'
    import Map from './Partials/Map.vue'
    import {useForm} from '@inertiajs/vue3'
    import axios from 'axios'

    const {auth} = defineProps(['auth'])
    const step = ref(1)
    const ruleTextfield = ref(1)

    const form = useForm({
        owner_id: auth.user.id,
        location: '',
        latitude: null,
        longitude: null,
        guests: 1,
        rooms: 0,
        bathrooms: 0,
        beds: 0,
        amenities: [],
        title: '',
        description: '',
        bldg_permit: null,
        price: 2500,
        images: null,
        type: null,
        rules: [],
        qr_code: null
    })
    
    const submit = () => {
        form.post('/owner/createListing')
    }

    const imageRules = [
        value => {
            if(value.length >= 5) return true
            return `Images should have at least 5 images` 
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
            icon: 'mdi-car-parking',
            title: 'Parking'
        },
        {
            icon: 'mdi-paw',
            title: 'Pet-Friendly'
        },
        {
            icon: 'mdi-smoking',
            title: 'Smoking Allowed'
        },
        {
            icon: 'mdi-hiking',
            title: 'Hiking Trails'
        },
        {
            icon: 'mdi-gamepad-variant',
            title: 'Game Room'
        },
        {
            icon: 'mdi-cctv',
            title: 'Security Cameras'
        },
        {
            icon: 'mdi-shower',
            title: 'Shower'
        },
        {
            icon: 'mdi-coffee',
            title: 'Coffee Maker'
        },
        {
            icon: 'mdi-silverware-fork-knife',
            title: 'Dining Area'
        },
        {
            icon: 'mdi-chair-school',
            title: 'Workspace'
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
        loadingGetCoord.value = true
        navigator.geolocation.getCurrentPosition((pos) => {
        axios.get(`https://nominatim.openstreetmap.org/reverse?lat=${pos.coords.latitude}&lon=${pos.coords.longitude}&format=json&limit=1`)
        .then(response => {
            console.log(response)
            form.latitude = response.data.lat
            form.longitude = response.data.lon
            form.location = response.data.display_name
            loadingGetCoord.value = false
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




</script>

<template>
    <Head title="Create listing" />
    <v-card max-width="100vw" max-height="100vh" elevation="0">
        <v-window v-model="step">
            <v-window-item :value="1">
                <v-container id="step1">
                    <v-row>
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6" xxl="6" class="mt-6">
                            <p class="text-h5">Step 1 </p>
                            <p class="text-h3 my-2 mx-2">Tell us about your place</p>
                            <p>Share details about your venue or location to help us better understand your space.</p>
                        </v-col>
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6" xxl="6">
                            <v-img cover height="100%" width="100%" src="/images/listing/Home-Interior-Design-PNG.png"></v-img>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>

            <v-window-item :value="2">
                <v-container id="step1">
                    <p class="text-center text-h4 mb-6">What type of place are you renting?</p>
                    <v-row justify="center">
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6" xxl="6">
                            <v-list>
                                <v-list-item value="gueshouse" active-color="blue" @click="form.type = 'Guest house'">
                                    <template v-slot:append>
                                        <v-icon size="50">
                                            mdi-home-outline
                                        </v-icon>
                                    </template>
                                    <p class="text-h6"> Guest house</p>
                                    <p class="text-none text-grey">A cozy and private guest house for your guests' comfort.</p>
                                </v-list-item>
                                <v-list-item value="room" active-color="blue" class="mt-6" @click="form.type = 'Room'">
                                    <template v-slot:append>
                                        <v-icon size="50">
                                            mdi-door-open
                                        </v-icon>
                                    </template>
                                    <p class="text-h6"> Single room</p>
                                    <p class="text-none text-grey">A comfortable single room with all the amenities you need.</p>
                                </v-list-item>
                                <v-list-item value="mutiple room" active-color="blue" class="mt-6" @click="form.type = 'Multiple room'">
                                    <template v-slot:append>
                                        <v-icon size="50">
                                            mdi-home-group
                                        </v-icon>
                                    </template>
                                    <p class="text-h6"> Mutiple room</p>
                                    <p class="text-none text-grey">A spacious place with multiple rooms.</p>
                                </v-list-item>
                                <!-- <v-list-item value="room" active-color="blue" class="mt-6" @click="form.type = 'Room'">
                                    <template v-slot:append>
                                        <v-icon size="50">
                                            mdi-bed
                                        </v-icon>
                                    </template>
                                    <p class="text-h6"> A guest room</p>
                                    <p class="text-none text-grey">Lorem ipsum dolor sit amet ndae cudwemque saepe!</p>
                                </v-list-item> -->
                            </v-list>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>

            <v-window-item :value="3">
                <v-container id="step1">
                    <p class="text-center text-h4 mb-6">Where's the {{form.type}} located?</p>
                    <v-row justify="center">
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6" xxl="6" class="mt-5">
                            <v-text-field variant="solo" :error-messages="form.errors.location" v-model="form.location" :loading="loadingGetCoord" color="blue" label="Location" @keydown.enter="getCoord()" rounded="pill"></v-text-field>
                            <p class="text-end text-blue-darken-4" id="location" @click="getLocation()">Use my current location</p>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
            
            <v-window-item :value="4">
                <v-container>
                    <p class="text-h6 text-grey-darken text-center">Click on the map to place the marker.</p>
                    <Map :latitude="form.latitude" v-if="step == 4" :longitude="form.longitude" @setPos="setPos" />
                </v-container>
            </v-window-item>

            <v-window-item :value="5">
                <v-container id="step1">
                    <p class="text-h4 my-3">Share some basics about your place</p>
                    <v-list>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus" v-if="form.guests > 1" @click="form.guests--"></v-btn>
                                <span class="text-h6">{{ form.guests }}</span>
                                <v-btn flat class="mx-1" icon="mdi-plus" @click="form.guests++"></v-btn>
                            </template>
                            <span class="text-h6">Guests</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item v-if="form.type == 'Guest house'">
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus" v-if="form.rooms > 1" @click="form.rooms--"></v-btn>
                                <span class="text-h6">{{ form.rooms }}</span>
                                <v-btn flat class="mx-1" icon="mdi-plus" @click="form.rooms++"></v-btn>
                            </template>
                            <span class="text-h6">Rooms</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus" v-if="form.beds > 1" @click="form.beds--"></v-btn>
                                <span class="text-h6">{{ form.beds }}</span>
                                <v-btn flat class="mx-1" icon="mdi-plus" @click="form.beds++"></v-btn>
                            </template>
                            <span class="text-h6">Beds</span>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <template v-slot:append>
                                <v-btn flat class="mx-1" icon="mdi-minus" v-if="form.bathrooms > 0" @click="form.bathrooms--"></v-btn>
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
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6" xxl="6" class="mt-6">
                            <p class="text-h5">Step 2</p>
                            <p class="text-h3 my-2 mx-2">Make your place stand out</p>
                            <p class="text-h6">Highlight the unique features and amenities that make your place special. 
        Whether it's breathtaking views, stylish decor, or outstanding service, 
        let potential guests know what sets your place apart from the rest.</p>
                        </v-col>
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6" xxl="6">
                            <v-img cover height="100%" width="100%" src="/images/listing/Home-Interior-Design-PNG.png"></v-img>
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
                            <p class="text-red" v-if="form.errors.amenities">Choose at least 1 amenity.</p>
                            <v-row>
                                <v-col v-for="item in placeOffers" :key="item" cols="12" sm="6" md="3" lg="3" xl="3" xxl="3" @click="form.amenities.push(item)">
                                    <v-item v-slot="{ isSelected, toggle }" >
                                        <v-card :color="isSelected ? 'blue-lighten-4' : ''" class="d-flex align-center border" dark height="50" @click="toggle">
                                            <div class=" flex-grow-1 text-center">
                                                <v-icon size="30">{{ item.icon }}</v-icon>
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
                    <p class="text-h4 mt-6 text-start">Now, let's give your {{form.type}} a title</p>
                    <p class="text-h6 mb-6 text-grey-darken">Short titles work best. Have fun with it—you can always change it later.</p>
                    <v-textarea v-model="form.title" :error-messages="form.errors.title" variant="outlined" counter="30">

                    </v-textarea>
                </v-container>
            </v-window-item>

            <v-window-item :value="9">
                <v-container id="step1" class="placeoffers">
                    <div v-if="form.type == 'Guest house'">
                        <p class="text-h5 text-start">Add some photos of your guest house.</p>
                        <p class="text-h6 mb-6 text-grey-darken-1 ms-3">You'll need 5 photos to get started. You can add more or make changes later.</p>
                        <v-file-input
                            chips
                            variant="outlined"
                            prepend-inner-icon="mdi-image-outline"
                            v-model="form.images"
                            multiple
                            :rules="imageRules"
                            :error-messages="form.errors.images"
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
                        <p class="text-h5 text-start">Upload the building permit of the guest house</p>
                        <p class="text-h6 mb-6 text-grey-darken-1 ms-3">You'll need it to confirm your listing.</p>
                        <v-file-input 
                            label="Building permit" 
                            variant="outlined" 
                            v-model="form.bldg_permit" 
                            color="blue"
                            name="bldg_permit"
                            prepend-inner-icon="mdi-image-outline">
                        </v-file-input>
                    </div>
                    <div v-else>
                        <p class="text-h5 text-start">Upload one photo of the room.</p>
                        <p class="text-h6 mb-2 text-grey-darken-1 ms-3"> Share the charm of your place by uploading a photo of the room.  </p>
                        <v-file-input 
                                label="Room photo" 
                                chips
                                variant="outlined" 
                                v-model="form.images" 
                                :error-messages="form.errors.images"
                                color="blue"
                                name="room_image"
                                prepend-inner-icon="mdi-image-outline">
                            </v-file-input>
                    </div>
                </v-container>
            </v-window-item>

            <v-window-item :value="10">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Next, let's describe your {{ form.type }}</p>
                    <p class="text-h6 mb-6 text-grey-darken text-start">Share what makes your place special.</p>
                    <v-textarea color="blue" variant="outlined" :error-messages="form.errors.description" v-model="form.description" counter="255" placeholder="You'll have a great time at this comfortable place to stay.">

                    </v-textarea>
                </v-container>
            </v-window-item>


            <v-window-item :value="11">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Now, set your {{form.type == 'Guest house' ? 'monthy' : 'daily'}} price</p>
                    <p class="text-h6 mb-6 text-grey-darken-2 text-start">You can change it anytime.</p>
                    
                    <input type="text" v-model="form.price" style="width: 300px;" class="text-h1 ms-6">
                </v-container>
            </v-window-item>

            <v-window-item :value="12">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Attach your QR Code</p>
                    <v-file-input v-model="form.qr_code"></v-file-input>
                </v-container>
            </v-window-item>

            <v-window-item :value="13">
                <v-container id="step1" class="placeoffers">
                    <p class="text-h4 text-start">Add rules regarding to your place.</p>
                    <p class="text-h6 mb-6 text-grey-darken-2 text-start"> Help us ensure a smooth and enjoyable experience for everyone. Please review and adhere to the following rules regarding your place: </p>
                    <v-text-field v-for="n in ruleTextfield" :key="n" v-model="form.rules[n-1]" variant="outlined" label="New rule" color="blue"></v-text-field>
                    <v-btn variant="tonal" block prepend-icon="mdi-plus" @click="ruleTextfield < 3 ? ruleTextfield++ : ''" color="blue">Add more</v-btn>
                    <v-btn variant="text" class="mt-2" color="blue" @click="step++">Set up later</v-btn>
                </v-container>
            </v-window-item>

            <v-window-item :value="14">
                <v-container id="step1">
                    <v-alert variant="outlined" type="error" prominent border="top" title="Alert title" v-if="form.hasErrors">
                        It seems that you may have not filled up the required fields.
                    </v-alert>
                    <v-row>
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6" xxl="6" class="mt-6">
                            <p class="text-h5">Step 3</p>
                            <p class="text-h3 my-2 mx-2">Finish up and publish</p>
                            
                            <v-list-item>
                                <template v-slot:prepend>
                                    <v-icon size="50" color="red">mdi-file-clock-outline</v-icon>
                                </template>
                                <p>Your listing won't be published until the admin  accepts your request.</p>
                          
                            </v-list-item>
                        </v-col>
                        <v-col cols="12" sm="12" md="6" lg="6" xl="6" xxl="6">
                            <v-img cover height="100%" width="100%" src="/images/listing/Home-Interior-Design-PNG.png"></v-img>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>

      </v-window>
  
      <div id="action">
        <v-divider></v-divider>
      <v-progress-linear :model-value="(step/14)*100" color="blue-darken-3"></v-progress-linear>
  
        <v-card-actions>
            <v-btn v-if="step > 1" variant="text" @click="step--">
                Back
            </v-btn>
            <v-spacer></v-spacer>
                <v-btn v-if="step <= 13" color="blue-lighten-3" class="text-none" size="large" variant="flat" @click="step++">
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