<script setup>

    import Layout from '../../Layouts/OwnerLayout.vue'
    import MazCarousel from 'maz-ui/components/MazCarousel'
    import MazCard from 'maz-ui/components/MazCard'
    import {ref} from 'vue'
    import {useForm, router} from '@inertiajs/vue3'
    
    const tab = ref(0)
    const props = defineProps(['listing'])
    const amenities = JSON.parse(props.listing.amenities)
    const showEditDetails = ref(true)
    const showEditProperties = ref(true)
    const showEditPhotos = ref(true)
    const successSnackbar = ref(false)
    const showDeleteModal = ref(false)

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
    })

    const photosForm = useForm({
        images: JSON.parse(props.listing.images)
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

    const deleteListing = () => {
        router.delete(`/owner/delete-listing/${props.listing.id}`, {
            preserveScroll: true,
        })
    }

    function deletePhoto(index) {
        photosForm.images = photosForm.images.splice(index, 1)
    }

    defineOptions({
        layout: Layout
    })
</script>
<template>
    <Head title="Edit listing" />
    <v-toolbar>
      <v-toolbar-title>Edit Listing <p class="text-red">doest not work rn</p> </v-toolbar-title>
    </v-toolbar>

    <div class="d-flex flex-row">
        <v-tabs v-model="tab" direction="vertical" color="blue">
            <v-tab value="option-1" class="text-none">
                <v-icon start>mdi-account</v-icon>
                Listing details
            </v-tab>
            <v-tab value="option-2" class="text-none">
                <v-icon start>mdi-lock</v-icon>
                Pricing and availability
                </v-tab>
            <v-tab value="option-3" class="text-none">
                <v-icon start> mdi-access-point</v-icon>
                Policies and rules
            </v-tab>
            
            <v-tab value="option-4" color="red" class="text-none text-red">
                <v-icon start> mdi-delete-outline</v-icon>
                Delete listing
            </v-tab>
            
        </v-tabs>
        <v-window v-model="tab">
            <v-window-item value="option-1">
                <v-card flat>
                    <MazCarousel>
                        <template #title>
                            <span class="text-h6"> Photos </span> <span class="text-red">not working rn</span>
                                <v-btn :append-icon="showEditPhotos ? 'mdi-pencil' : 'mdi-close'" variant="text" color="blue" class="text-none" @click="showEditPhotos = !showEditPhotos">
                                    Edit
                                </v-btn> 
                                <v-btn append-icon="mdi-image-plus-outline" variant="text" color="green" class="text-none" v-show="!showEditPhotos">
                                    Add new photo
                                </v-btn>
                        </template>
                        <MazCard galleryWidth="100%" v-for="(item, i) in photosForm.images" zoom :key="i" :images="[`/images/${photosForm.images[i]}`]" style="min-width: 250px;">
                            <v-row v-if="!showEditPhotos">
                                <v-col cols="6">
                                    <v-btn prepend-icon="mdi-close" @click="photosForm.images.splice(i, 1)" variant="text" color="red" class="text-none">
                                        Remove {{ i }}
                                    </v-btn>
                                </v-col>
                                <v-col cols="6">
                                    <v-btn prepend-icon="mdi-image-edit-outline" variant="text" color="blue" class="text-none">
                                        Change
                                    </v-btn>  
                                </v-col>
                            </v-row>
                        </MazCard>
                    </MazCarousel>
                <v-divider class="mt-4"/>
                <span class="text-h6">Listing basics</span>
                <v-btn :append-icon="showEditDetails ? 'mdi-pencil' : 'mdi-close'" variant="text" @click="showEditDetails = !showEditDetails" class="text-none" color="blue">Edit</v-btn> 
                <v-list width="100%">
                    <v-form @submit.prevent>
                        <v-list-item>
                        Listing title
                        <v-text-field :disabled="showEditDetails" v-model="detailsForm.title" variant="outlined"></v-text-field>
                    </v-list-item>
                    <v-list-item>
                        Listing description
                        <v-textarea :disabled="showEditDetails" v-model="detailsForm.description" variant="outlined"></v-textarea>
                    </v-list-item>
                    <v-list-item>
                        Listing location
                        <v-text-field :disabled="showEditDetails" v-model="detailsForm.location" variant="outlined"></v-text-field>
                    </v-list-item>
                    <v-row class="justify-end d-flex mb-1 me-4">
                        <v-col cols="1">
                            <v-btn color="blue" type="submit" class="rounded-pill text-none" :loading="detailsForm.processing" @click="submitDetailsForm" v-show="!showEditDetails">Save</v-btn>
                        </v-col>
                    </v-row>
                    </v-form>
                    <v-divider/>
                    <v-list>
                        <span class="text-h6">Properties and rooms</span> <span class="text-red">not working rn</span>
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
                            <v-chip :prepend-icon="item.icon" v-for="item in amenities" :key="item.title" class="mx-2 my-1">{{ item.title }}</v-chip>
                            <v-chip prepend-icon="mdi-plus" color="green" v-show="!showEditProperties">Add</v-chip>
                        </v-container>
                        <v-card-actions class="justify-end d-flex">
                            <v-btn color="blue" variant="flat" class="text-none rounded-pill" v-show="!showEditProperties">Save</v-btn>
                        </v-card-actions>
                    <v-divider/>

                </v-list>
                </v-card>
            </v-window-item>
            <v-window-item value="option-2">
                <v-card flat>
                    <span class="text-red">not working rn</span>
                    <v-card-item>
                        <v-text-field type="number" label="Pricing"></v-text-field>
                        <v-text-field type="number" label="Add discount"></v-text-field>
                        <v-select label="Availability" :items="['Available', 'Not available']">
                        </v-select>
                    </v-card-item>
                    <v-card-actions class="d-flex justify-end">
                        <v-btn color="blue" class="text-none" variant="flat">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-window-item>
            <v-window-item value="option-3">
                <v-card width="69vw" height="100%">
                    <v-card-item>
                        <v-list>
                            <span class="text-red">not working rn</span>
                            <v-list-item prepend-icon="mdi-home">
                                Rules and policies
                            </v-list-item>
                            <v-list-item>
                                Lorem ipsum dolor sit amet consectetur.
                            </v-list-item>
                        </v-list>
                        <v-textarea>

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

</style>