<script setup>

    import OwnerLayout from '../../Layouts/OwnerLayout.vue'
    import {ref, watch} from 'vue'
    import {useForm, router} from '@inertiajs/vue3'
    
    const tab = ref(0)
    const props = defineProps(['listing'])
    const showEditDetails = ref(true)
    const showEditProperties = ref(true)
    const showEditPhotos = ref(true)
    const showDeleteModal = ref(false)
    const successSnackbar = ref(false)
    const addPhoto = ref(null)

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

    watch(addPhoto, () => {
        console.log(addPhoto.value[0].name)
        addPhoto.value.forEach(element => {
            photosForm.images.push(element.name)
        })
    })

    const photosForm = useForm({
        images: JSON.parse(props.listing.images)
    })

    const detailsForm = useForm({
        title: props.listing.title,
        description: props.listing.description,
        location: props.listing.location,
    })

    const propertyForm = useForm({
        guests: props.listing.guests,
        beds: props.listing.beds,
        rooms: props.listing.rooms,
        bathrooms: props.listing.bathrooms,
        amenities: JSON.parse(props.listing.amenities)
    })

    const pricingForm = useForm({
        price: props.listing.price,
        monthly_discount: props.listing.monthly_discount,
        status: props.listing.status,
    })


    const submitDetailsForm = () => {
        detailsForm.put(`/owner/update-listing/details/${props.listing.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                showEditDetails.value = true
                successSnackbar.value = true
            }
        })
    }

    const submitPhotosForm = () => {
        photosForm.put(`/owner/update-listing/photos/${props.listing.id}`, {
            onSuccess: () => {
                showEditPhotos.value = true
                successSnackbar.value = true
            }
        })
    }

    const submitPropertyForm = () => {
        propertyForm.put(`/owner/update-listing/property/${props.listing.id}`, {
            onSuccess: () => {
                showEditProperties.value = true
                successSnackbar.value = true
            },
            preserveScroll: true,
        })
    }

    const submitPricingForm = () => {
        pricingForm.put(`/owner/update-listing/pricing/${props.listing.id}`, {
            onSuccess: () => {
                successSnackbar.value = true
            },
        })
    }

    const deleteListing = () => {
        router.delete(`/owner/delete-listing/${props.listing.id}`, {
            preserveScroll: true,
        })
    }

    const handleChipClick = (item, toggle) => {
        toggle(); // Call the toggle function
        propertyForm.amenities.push(item); // Push the item to propertyForm.amenities
    };

    defineOptions({
        layout: OwnerLayout
    })
</script>
<template>
    <Head title="Edit listing" />
    <v-container>
        <v-toolbar>
            <v-toolbar-title>Edit listing( {{ listing.title }} )</v-toolbar-title>
        </v-toolbar>

        <div class="d-flex flex-row">
            <v-tabs v-model="tab" direction="vertical" color="blue">
                <v-tab value="option-1" class="text-none">
                    <v-icon start>mdi-home-edit</v-icon>
                    Listing details
                </v-tab>
                <v-tab value="option-2" class="text-none">
                    <v-icon start>mdi-cash</v-icon>
                    Pricing and availability
                    </v-tab>
                <v-tab value="option-3" class="text-none">
                    <v-icon start> mdi-shield-edit</v-icon>
                    Policies and rules
                </v-tab>
                
                <v-tab value="option-4" color="red" class="text-none text-red">
                    <v-icon start> mdi-delete-outline</v-icon>
                    Delete listing
                </v-tab>
                
            </v-tabs>
            <v-window v-model="tab">
                <v-window-item value="option-1">
                    <v-card flat border class="pa-2">
                        <span class="text-h6"> Photos </span> 
                            <v-btn :append-icon="showEditPhotos ? 'mdi-pencil' : 'mdi-close'" variant="text" color="blue" class="text-none" @click="showEditPhotos = !showEditPhotos">
                                Edit
                            </v-btn> 
                            <v-file-input label="Add new photos" color="blue" multiple v-model="addPhoto" variant="outlined" v-if="!showEditPhotos"></v-file-input>
                        <v-slide-group v-model="model" class="pa-4" show-arrows>
                            <v-slide-group-item v-for="(item, i) in photosForm.images" :key="i">
                                <v-badge class="mt-2" @click="photosForm.images.splice(i, 1)" offset-x="15" color="red" icon="mdi-close" id="badge">
                                    <v-card class="mx-4 " height="230" width="250" elevation="0">
                                        <v-img :src="`/images/${photosForm.images[i]}`" height="180" cover></v-img>
                                    </v-card>
                                </v-badge>
                            </v-slide-group-item>
                        </v-slide-group>
                        <v-row class="justify-end d-flex mb-1 me-4">
                            <v-col cols="1">
                                <v-btn color="blue" type="submit" class="rounded-pill text-none" :loading="photosForm.processing" @click="submitPhotosForm" v-show="!showEditPhotos">Save</v-btn>
                            </v-col>
                        </v-row>
                        <v-divider/>
                        <span class="text-h6">Listing basics</span>
                        <v-btn :append-icon="showEditDetails ? 'mdi-pencil' : 'mdi-close'" variant="text" @click="showEditDetails = !showEditDetails" class="text-none" color="blue">Edit</v-btn> 
                        <v-list width="100%">
                            <v-form @submit.prevent>
                                <v-list-item>
                                    Title
                                    <v-text-field :disabled="showEditDetails" color="blue" v-model="detailsForm.title" variant="outlined"></v-text-field>
                                </v-list-item>
                                <v-list-item>
                                    Description
                                    <v-textarea :disabled="showEditDetails" color="blue" v-model="detailsForm.description" variant="outlined"></v-textarea>
                                </v-list-item>
                                <v-list-item>
                                    Location
                                    <v-text-field :disabled="showEditDetails" color="blue" v-model="detailsForm.location" variant="outlined"></v-text-field>
                                </v-list-item>
                                <v-row class="justify-end d-flex mb-1 me-4">
                                    <v-col cols="1">
                                        <v-btn color="blue" type="submit" class="rounded-pill text-none" :loading="detailsForm.processing" @click="submitDetailsForm" v-show="!showEditDetails">Save</v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                            <v-divider/>
                            <v-list>
                                <span class="text-h6">Property and amenities</span> 
                                <v-btn :append-icon="showEditProperties ? 'mdi-pencil' : 'mdi-close'" variant="text" @click="showEditProperties = !showEditProperties" class="text-none" color="blue">Edit</v-btn> 
                                <v-list-item>
                                    Number of guests
                                    <template v-slot:append>
                                        <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.guests++" v-show="!showEditProperties"></v-btn>
                                        {{ propertyForm.guests }}
                                        <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.guests--" v-show="!showEditProperties"></v-btn>
                                    </template>
                                </v-list-item>
                                <v-list-item>
                                    Number of bed
                                    <template v-slot:append>
                                        <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.beds++" v-show="!showEditProperties"></v-btn>
                                        {{ propertyForm.beds }}
                                        <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.beds--" v-show="!showEditProperties"></v-btn>
                                    </template>
                                </v-list-item>
                                <v-list-item>
                                    Number of rooms
                                    <template v-slot:append>
                                        <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.rooms++" v-show="!showEditProperties"></v-btn>
                                        {{ propertyForm.rooms }}
                                        <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.rooms--" v-show="!showEditProperties"></v-btn>
                                    </template>
                                </v-list-item>
                                <v-list-item>
                                    Number of bathroom
                                    <template v-slot:append>
                                        <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.bathrooms++" v-show="!showEditProperties"></v-btn>
                                        {{ propertyForm.bathrooms }}
                                        <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.bathrooms--" v-show="!showEditProperties"></v-btn>
                                    </template>
                                </v-list-item>
                            </v-list>
                            <p class="text-h6">Amenities</p>
                                <v-container>
                                    <v-chip :prepend-icon="item.icon" v-for="item in propertyForm.amenities" :key="item.title" class="mx-2 my-1">{{ item.title }}</v-chip>
                                    <v-card  v-show="!showEditProperties" elevation="0" class="border mt-4">
                                        <v-card-title>Add amenities</v-card-title>
                                        <v-card-item>
                                            <v-item-group multiple selected-class="bg-blue" >
                                                <v-item v-for="item in placeOffers" :key="item.title" v-slot="{ selectedClass, toggle }">
                                                    <v-chip :class="[selectedClass, 'ma-1']" @click="handleChipClick(item, toggle)" :prepend-icon="item.icon">
                                                        {{ item.title }}
                                                    </v-chip>
                                                </v-item>
                                            </v-item-group>
                                        </v-card-item>
                                    </v-card>
                                </v-container>
                                <v-card-actions class="justify-end d-flex">
                                    <v-btn color="blue" variant="flat" class="text-none rounded-pill" type="submit" v-show="!showEditProperties" @click="submitPropertyForm" :loading="propertyForm.processing">Save</v-btn>
                                </v-card-actions>
                        </v-list>
                    </v-card>
                </v-window-item>
                <v-window-item value="option-2">
                    <v-card flat>
                        <v-card-item>
                            <v-text-field type="number" color="blue" v-model="pricingForm.price" variant="outlined" label="Price" class="mt-2"></v-text-field>
                            <v-text-field type="number" color="blue" v-model="pricingForm.monthly_discount" variant="outlined" label="Add discount"></v-text-field>
                            <v-select label="Availability" color="blue" v-model="pricingForm.status" variant="outlined" :items="['Available', 'Not available']">
                            </v-select>
                        </v-card-item>
                        <v-card-actions class="d-flex justify-end">
                            <v-btn color="blue" class="text-none" variant="flat" type="submit" :loading="pricingForm.processing" @click="submitPricingForm">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-window-item>
                <v-window-item value="option-3">
                    <v-card width="69vw" height="100%">
                        <v-card-item>
                                <span class="text-red">not working rn</span>
                                    <p class="text-h6">Rules and policies</p>
                                    <p v-for="rule in JSON.parse(listing.rules)" :key="rule">
                                       <v-icon>mdi-circle-small</v-icon> {{ rule }}
                                    </p>
                                
                            <v-textarea class="mt-3" variant="outlined" color="blue" placeholder="" label="Add new rule">
                                
                            </v-textarea>
                            
                        </v-card-item>
                        <v-card-actions class="justify-end d-flex">
                            <v-btn class="text-none" variant="flat" prepend-icon="mdi-plus" color="blue">Add</v-btn>
                        </v-card-actions>
                    </v-card>
                    
                </v-window-item>
                <v-window-item value="option-4">
                    <v-card flat>
                        <v-card-text>
                            <v-btn class="text-none" color="red" @click="showDeleteModal = true">Delete listing</v-btn>
                        </v-card-text>
                    </v-card>
                </v-window-item>
            </v-window>
        </div>
    </v-container>
    <!-- DELETE LISTING MODAL -->
    <v-dialog v-model="showDeleteModal" width="auto">
        <v-card class="justify-center" width="600">
            <v-form @submit.prevent>
                <v-sheet elevation="12" rounded="lg" class="pa-4 text-center mx-auto">
                    <v-icon class="mb-5" color="red" icon="mdi-close-circle" size="112"></v-icon>
                    <h2 class="text-h5 mb-6">Are you sure?</h2>
                    <p class="mb-4 text-medium-emphasis text-body-2">
                        This will delete listing <strong>{{ listing.title }}</strong>
                        <br> This process cannot be undone.
                    </p>
                    <v-divider class="mb-4"></v-divider>
                    <div class="text-end">
                        <v-btn class="text-none me-4" @click="showDeleteModal = false" color="grey" rounded variant="flat" width="90">
                            Cancel
                        </v-btn>
                        <v-btn class="text-none" color="red" type="submit" @click="deleteListing" rounded variant="flat" width="90">
                            Delete
                        </v-btn>
                    </div>
                </v-sheet>
            </v-form>
        </v-card>
    </v-dialog>
    <!-- UPDATE SUCCESSFUL SNACKBAR -->
    <v-snackbar v-model="successSnackbar" color="green">
        Updated Successfully
        <template v-slot:actions>
            <v-btn color="white" icon="mdi-close" @click="successSnackbar = false">
            </v-btn>
        </template>
    </v-snackbar>
</template>

<style scoped>

    #badge:hover {
        cursor: pointer;
    }

</style>