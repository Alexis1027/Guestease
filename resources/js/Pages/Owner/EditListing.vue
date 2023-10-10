<script setup>

    import Layout from '../../Layouts/OwnerLayout.vue'
    import MazCarousel from 'maz-ui/components/MazCarousel'
    import MazCard from 'maz-ui/components/MazCard'
    import {ref} from 'vue'
    import {useForm, router} from '@inertiajs/vue3'
    

    const props = defineProps(['listing'])
    const images = JSON.parse(props.listing.images)
    const amenities = JSON.parse(props.listing.amenities)
    const disableDetails = ref(true)
    const disableProperties = ref(true)
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

    const submitDetailsForm = () => {
        detailsForm.put(`/owner/update-listing/details/${props.listing.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                disableDetails.value = true
                successSnackbar.value = true
            }
        })
    }

    const deleteListing = () => {
        router.delete(`/owner/delete-listing/${props.listing.id}`, {
            preserveScroll: true,
        })
    }

    const tab = ref(0)
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
                            <p class="text-h6">Photos</p>
                        </template>
                        <MazCard galleryWidth="100%" :elevation="0" v-for="(item, i) in images" zoom :key="i" :images="[`/images/${images[i]}`]" style="min-width: 250px;">
                        </MazCard>
                    </MazCarousel>
                <v-divider class="mt-4"/>
                <span class="text-h6">Listing basics</span>
                <v-btn :append-icon="disableDetails ? 'mdi-pencil' : 'mdi-close'" variant="text" @click="disableDetails = !disableDetails" class="text-none" color="blue">Edit</v-btn> 
                <v-list width="100%">
                    <v-form @submit.prevent>
                        <v-list-item>
                        Listing title
                        <v-text-field :disabled="disableDetails" v-model="detailsForm.title" variant="outlined"></v-text-field>
                    </v-list-item>
                    <v-list-item>
                        Listing description
                        <v-textarea :disabled="disableDetails" v-model="detailsForm.description" variant="outlined"></v-textarea>
                    </v-list-item>
                    <v-list-item>
                        Listing location
                        <v-text-field :disabled="disableDetails" v-model="detailsForm.location" variant="outlined"></v-text-field>
                    </v-list-item>
                    <v-row class="justify-end d-flex mb-1 me-4">
                        <v-col cols="1">
                            <v-btn color="blue" type="submit" class="rounded-pill text-none" :loading="detailsForm.processing" @click="submitDetailsForm" v-show="!disableDetails">Save</v-btn>
                        </v-col>
                    </v-row>
                    </v-form>
                    <v-divider/>
                    <v-list>
                        <span class="text-h6">Properties and rooms</span>
                        <v-btn :append-icon="disableProperties ? 'mdi-pencil' : 'mdi-close'" variant="text" @click="disableProperties = !disableProperties" class="text-none" color="blue">Edit</v-btn> 
                        <v-list-item>
                            Number of guests
                            <template v-slot:append>
                                <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.guests++" v-show="!disableProperties"></v-btn>
                                {{ propertyForm.guests }}
                                <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.guests--" v-show="!disableProperties"></v-btn>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            Number of bed
                            <template v-slot:append>
                                <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.beds++" v-show="!disableProperties"></v-btn>
                                {{ propertyForm.beds }}
                                <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.beds--" v-show="!disableProperties"></v-btn>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            Number of rooms
                            <template v-slot:append>
                                <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.rooms++" v-show="!disableProperties"></v-btn>
                                {{ propertyForm.rooms }}
                                <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.rooms--" v-show="!disableProperties"></v-btn>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            Number of bathroom
                            <template v-slot:append>
                                <v-btn icon="mdi-plus" flat size="small" @click="propertyForm.bathrooms++" v-show="!disableProperties"></v-btn>
                                {{ propertyForm.bathrooms }}
                                <v-btn icon="mdi-minus" flat size="small" @click="propertyForm.bathrooms--" v-show="!disableProperties"></v-btn>
                            </template>
                        </v-list-item>
                    </v-list>
                    <p class="text-h6">Amenities</p>
                        <v-container>
                            <v-chip :prepend-icon="item.icon" v-for="item in amenities" :key="item.title" class="mx-2 my-1">{{ item.title }}</v-chip>
                            <v-chip prepend-icon="mdi-plus" color="green">Add</v-chip>
                        </v-container>
                        <v-card-actions class="justify-end d-flex">
                            <v-btn color="blue" variant="flat" class="text-none rounded-pill" v-show="!disableProperties">Save</v-btn>
                        </v-card-actions>
                    <v-divider/>

                </v-list>
                </v-card>
            </v-window-item>
            <v-window-item value="option-2">
                <v-card flat>
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
                        <v-btn class="text-none" variant="flat" color="blue">Add</v-btn>
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
        <v-card>
            <v-card-title>
                Delete listing
            </v-card-title>
            <v-card-text>
                Are you sure you want to delete this listing?
            </v-card-text>
            <v-card-actions class="justify-end d-flex">
                <v-form>
                    <v-btn color="grey" @click="showDeleteModal = false">No</v-btn>
                    <v-btn color="red" @click="deleteListing">Yes</v-btn>
                </v-form>
            </v-card-actions>
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