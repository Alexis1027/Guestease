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
    const fileInputRef = ref(null)

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

    // watch(addPhoto, () => {
    //     addPhoto.value.forEach(element => {
    //         photosForm.images.push(element.name)
    //     })
    // })

    const photosForm = useForm({
        new_image: [],
        images: JSON.parse(props.listing.images)
    })

    const ruleForm = useForm({
        newRule: null
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

    const submitRuleForm = () => {
        ruleForm.put(`/owner/update-listing/rules/${props.listing.id}`,
        {
            onSuccess: () => {
                showEditDetails.value = true
                successSnackbar.value = true
                ruleForm.newRule = null
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

    const photoIndex = ref(null)
    function openFileInput(index) {
        photoIndex.value = index
        const inputElement = fileInputRef.value.$el.querySelector('input');
        if (inputElement !== null) {
            inputElement.click();
        }
    }

    // const newPhoto = ref(null)
    // function openNewPhotoInput() {
    //     const inputElement = fileInputRef.value.$el.querySelector('input');

    // }

    watch(addPhoto, () => {
        console.log(photosForm.images)
        console.log(addPhoto.value[0].name)
        console.log(photosForm.images[photoIndex.value])
        photosForm.images[photoIndex.value] = addPhoto.value[0].name
    })

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
                <v-tab value="option-1" class="text-none bg-white">
                    <v-icon start>mdi-home-edit</v-icon>
                    Listing details
                </v-tab>
                <v-tab value="option-2" class="text-none bg-white">
                    <v-icon start>mdi-cash</v-icon>
                    Pricing and availability
                    </v-tab>
                <v-tab value="option-3" class="text-none bg-white">
                    <v-icon start> mdi-shield-edit</v-icon>
                    Policies and rules
                </v-tab>
                
                <!-- <v-tab value="option-4" color="red" class="text-none text-red bg-white">
                    <v-icon start> mdi-delete-outline</v-icon>
                    Delete listing
                </v-tab> -->
                
            </v-tabs>
            <v-window v-model="tab">
                <v-window-item value="option-1">
                    
                    <v-card flat border class="pa-2" width="100%">
                        <v-form @submit.prevent enctype="multipart/form-data">
                            <span class="text-h6"> Photos </span> 
                                <v-btn :append-icon="showEditPhotos ? 'mdi-pencil' : 'mdi-close'" variant="text" color="blue" class="text-none" @click="showEditPhotos = !showEditPhotos">
                                    Edit
                                </v-btn> 
                                <v-file-input style="position: relative; overflow: hidden; width: 0; height: 0;" ref="fileInputRef" label="Add new photos"  chips color="blue" multiple v-model="addPhoto" variant="outlined" ></v-file-input>
                                <!-- <v-file-input ref="fileInputRef" label="Add new photos"  chips color="blue" multiple v-model="addPhoto" variant="outlined" v-if="!showEditPhotos && listing.type == 'Guest house'"></v-file-input> -->
                                <!-- <v-file-input label="Add new photos" chips color="blue" v-model="addPhoto" variant="outlined" v-if="!showEditPhotos && (listing.type == 'Room' || listing.type == 'Multiple room')"></v-file-input> -->
                            <div >
                                <v-slide-group v-model="model" class="pa-4" show-arrows >
                                    <v-slide-group-item v-for="(item, i) in photosForm.images" :key="i">
                                        <v-card class="mx-4 " height="230" width="250" elevation="0">
                                            <v-img :src="`/images/uploads/${photosForm.images[i]}`" height="180" cover></v-img>
                                            <v-card-actions v-show="!showEditPhotos">
                                                <v-tooltip location="bottom">
                                                    <template v-slot:activator="{ props }">
                                                        <v-btn icon="mdi-image-edit-outline" @click="openFileInput(i)" v-bind="props"></v-btn>
                                                    </template>
                                                    <span>Change image</span>
                                                </v-tooltip>
                                            </v-card-actions>
                                        </v-card>
                                    </v-slide-group-item>
                                </v-slide-group>
                            </div>
                            <v-row class="justify-end d-flex mb-1 me-4">
                                <v-col cols="1">
                                    <v-btn color="blue" type="submit" class="rounded-pill text-none" :loading="photosForm.processing" @click="submitPhotosForm" v-show="!showEditPhotos">Save</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                        <v-divider/>
                        <span class="text-h6">Listing basics</span>
                        <v-btn :append-icon="showEditDetails ? 'mdi-pencil' : 'mdi-close'" variant="text" @click="showEditDetails = !showEditDetails" class="text-none" color="blue">Edit</v-btn> 
                        <v-list width="100%">
                            <v-list-item>
                                    Type : {{ listing.type }}
                                </v-list-item>
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
                                        <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.guests--" v-show="!showEditProperties && propertyForm.guests >= 2"></v-btn>
                                    </template>
                                </v-list-item>
                                <v-list-item>
                                    Number of bed
                                    <template v-slot:append>
                                        <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.beds++" v-show="!showEditProperties"></v-btn>
                                        {{ propertyForm.beds }}
                                        <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.beds--" v-show="!showEditProperties && propertyForm.beds >= 1"></v-btn>
                                    </template>
                                </v-list-item>
                                <v-list-item v-if="listing.type == 'Guest house'">
                                    Number of rooms
                                    <template v-slot:append>
                                        <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.rooms++" v-show="!showEditProperties"></v-btn>
                                        {{ propertyForm.rooms }}
                                        <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.rooms--" v-show="!showEditProperties && propertyForm.rooms >= 2"></v-btn>
                                    </template>
                                </v-list-item>
                                <v-list-item>
                                    Number of bathroom
                                    <template v-slot:append>
                                        <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.bathrooms++" v-show="!showEditProperties"></v-btn>
                                        {{ propertyForm.bathrooms }}
                                        <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.bathrooms--" v-show="!showEditProperties && propertyForm.bathrooms >= 1"></v-btn>
                                    </template>
                                </v-list-item>
                            </v-list>
                            <p class="text-h6">Amenities</p>
                                <v-container>
                                    <v-chip :prepend-icon="item.icon" v-for="item in propertyForm.amenities" :key="item.title" class="mx-2 my-1">{{ item.title }}</v-chip>
                                    <v-card  v-show="!showEditProperties" elevation="0" class="border mt-4">
                                        <v-card-title>Add amenities
                                            <p class="text-caption">Click icons to add</p>
                                        </v-card-title>
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
                                    <v-btn color="grey" variant="flat" class="text-none rounded-pill" type="submit" v-show="!showEditProperties" @click="showEditProperties = !showEditProperties" :loading="propertyForm.processing">Cancel</v-btn>
                                    <v-btn color="blue" variant="flat" class="text-none rounded-pill" type="submit" v-show="!showEditProperties" @click="submitPropertyForm" :loading="propertyForm.processing">Save</v-btn>
                                </v-card-actions>
                        </v-list>
                    </v-card>
                </v-window-item>
                <v-window-item value="option-2">
                    <v-card flat>
                        <v-card-item>
                            <v-text-field type="number" color="blue" v-model="pricingForm.price" variant="outlined" label="Price" class="mt-2"></v-text-field>
                            <v-text-field type="number" v-if="listing.type == 'Guest house'" color="blue" v-model="pricingForm.monthly_discount" variant="outlined" label="Add discount"></v-text-field>
                            <v-select label="Availability" :disabled="pricingForm.status == 'For approval' || pricingForm.status == 'Rejected' ? true : false" color="blue" v-model="pricingForm.status" variant="outlined" :items="['Available', 'Not available']">
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
                                <p class="text-h6">Rules and policies</p>
                                <p v-for="rule in JSON.parse(listing.rules)" :key="rule">
                                    <v-icon>mdi-circle-small</v-icon> {{ rule }}
                                </p>
                                <v-textarea class="mt-3" v-model="ruleForm.newRule" variant="outlined" color="blue" placeholder="" label="Add new rule">
                                </v-textarea>
                            </v-card-item>
                            <v-card-actions class="justify-end d-flex">
                                <v-btn class="text-none" @click="submitRuleForm" type="submit" variant="flat" prepend-icon="mdi-plus" color="blue">Add</v-btn>
                            </v-card-actions>
                    </v-card>
                    
                </v-window-item>
            </v-window>
        </div>
    </v-container>
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