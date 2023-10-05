<script setup>

    import Layout from '../../Layouts/OwnerLayout.vue';
    import {processImages} from '@/utils/imageUtils'
    import {ref} from 'vue'
    import {useForm} from '@inertiajs/vue3'

    defineOptions({
        layout: Layout
    })

    const form = useForm({
        bldg_permit: null
    })

    const submit = () => {
        form.post('/owner/verify-listing/1')
    }

    const {listing} = defineProps(['listing'])
    const addBuildingPermitDialog = ref(false)
    const images = processImages(listing.images)

</script>
<template>

    <Head title="Verify Listing" />

    <v-container class="bg-white">
        <v-row justify="center" align="center">
            <v-col cols="7">

                <p class="font-weight-bold text-h5">Key details to take care of</p>

                <v-list-item class="my-6" title="Create your listing">
                    <p class="font-weight-bold">
                        <v-icon color="green" size="20">mdi-check-circle</v-icon> 
                        Complete
                    </p>
                </v-list-item>
                <!-- <v-divider />
                <v-list-item class="my-6" title="Verify your identity">
                    <template v-slot:append>
                        <v-btn flat icon="mdi-chevron-right"></v-btn>
                    </template>
                    <p class="text-grey-darken-2">This is a simple way to help guests feel confident booking your place.</p>
                    <p class="font-weight-bold">Required</p>
                </v-list-item> -->
                <v-divider />
                <!-- <v-list-item class="mt-6" title="Confirm your email address">
                    <template v-slot:append>
                        <Link href="/settings"><v-btn flat icon="mdi-chevron-right"></v-btn></Link>
                    </template>
                    <p class="text-grey-darken-2">We'll email you to confirm your email address.</p>
                    <p class="font-weight-bold">Required</p>
                </v-list-item> -->
                <v-list-item class="my-6" title="Confirm your email address">
                    <p class="font-weight-bold">
                        <v-icon color="green" size="20">mdi-check-circle</v-icon> 
                        Complete
                    </p>
                </v-list-item>
                <v-divider />
                
                    <v-list-item class="mt-6" title="Verify your listing">
                        <template v-slot:append>
                            <v-btn flat icon="mdi-chevron-right" @click="addBuildingPermitDialog = true"></v-btn>
                        </template>
                        <p class="text-grey-darken-2">We'll need you to upload the building permit.</p>
                        <p class="font-weight-bold">Required</p>
                    </v-list-item>
                    
                
            </v-col>
            <v-divider vertical/>
            <v-col cols="4" class="d-flex ms-6">

                <v-card variant="outlined" color="grey" class="rounded-xl" width="100%" height="100%">
                    <v-img :src="`../../images/${images[0]}`" height="250" cover width="100%"></v-img>
                    <v-card-text class="text-black">
                        <p class="font-weight-bold">{{ listing.title }}</p>
                    <p>{{ listing.location }}</p>
                    </v-card-text>
                </v-card>

            </v-col>

        </v-row>

        <v-row justify="end">
            <v-btn class="text-none me-6" disabled size="large" color="blue">Publish listing</v-btn>
        </v-row>
    </v-container>

    <v-dialog
      v-model="addBuildingPermitDialog"
      width="auto"
      persistent
    >
      <v-card>
        <v-card-text>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          <v-file-input
                accept="image/*"
                label="File input"
                v-model="form.bldg_permit"
                @input="submit"
                :loading="form.processing"
            ></v-file-input>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" :disabled="form.processing" block @click="addBuildingPermitDialog = false">Close Dialog</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

</template>

<style scoped>

    .v-row{
        margin-top: 3%;
    }
.v-container {
        height: 80vh;
    }

</style>