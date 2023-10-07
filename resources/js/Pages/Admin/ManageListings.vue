<script setup>

    import {ref, defineProps, watch} from 'vue'
    import {router} from '@inertiajs/vue3'
    import Layout from '../../Layouts/AdminLayout.vue'
    import DeleteListingModal from './partials/DeleteListingModal.vue'
    import EditListingModal from './partials/EditListingModal.vue'

    defineProps({listings: Object, newEntry: Object})
    const deleteListingModal = ref(false)
    const editListingModal = ref(false)
    const deleteSnackbar = ref(false)
    const createSnackbar = ref(false)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref()
    const listing = ref({})

    function deleteListing(gh) {
        listing.value = gh
        deleteListingModal.value = true
    }

    watch(entry, () => {
        router.get(`/admin/manage-listings/${entry.value}`)
    })

    function editListing(gh) {
        listing.value = gh
        editListingModal.value = true
    }

    defineOptions({layout: Layout})
</script>




<template>
    <Head title="Manage Listings" />
    <v-container class="bg-white">
        <v-row justify="space-between">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
            <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field>
        </v-col>
        </v-row>
        <v-table hover class="bg-grey-lighten-5 text-center">
        <thead>
            <tr >
                <th class="text-center">Id</th>
                <th class="text-center">Owner Id</th>
                <th class="text-center">Image</th>
                <th class="text-center">Listing name</th>
                <th class="text-center">Location</th>
                <th class="text-center">Price</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <v-slide-x-transition class="py-0" group>
                <tr v-for="listing in listings.data" :key="listing.id">
                    <td>{{ listing.id }}</td>
                    <td>{{ listing.owner_id }}</td>
                    <td class="text-red"> <v-img cover class="my-1" :src="`../images/room1.png`"></v-img> </td>
                    <td>{{ listing.title }}</td>
                    <td>{{ listing.location }}</td>
                    <td> {{ '₱'+parseInt(listing.price).toLocaleString() }} </td>
                    <td>
                        <v-btn size="small" @click="editListing(listing)" variant="tonal" class="text-none bg-grey-lighten-5 me-2 text-blue">
                            <v-icon>mdi-pencil</v-icon> Edit
                        </v-btn>
                        <v-btn @click="deleteListing(listing)" size="small" variant="tonal" class="text-none bg-grey-lighten-5 text-red">
                            <v-icon>mdi-delete-outline</v-icon> Delete
                        </v-btn>
                    </td>
                </tr>
            </v-slide-x-transition>
            <tr v-if="listings.data.length <= 0">
                <td class="text-h6" colspan="6">No listing found.</td>
            </tr>
        </tbody>
    </v-table>
    <v-row  class="mt-2">
        <v-col class="d-flex justify-end">
            <Link 
                v-for="link in listings.links" 
                :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                :key="link" 
                :href="link.url"
                v-html="link.label"
                >
            </Link>
        </v-col>
    </v-row>
    
    </v-container>

    <DeleteListingModal :listing="listing" @showDeleteSuccessfulSnackbar="deleteSnackbar = true" :show="deleteListingModal" @CloseDialog="deleteListingModal = false" v-model="deleteListingModal" />
    <EditListingModal :listing="listing" :show="editListingModal" @CloseDialog="editListingModal = false" v-model="editListingModal" />

    <v-snackbar
      v-model="deleteSnackbar"
      color="red-lighten-3"
      timeout="1500"
    >
      Deleted successfully

      <template v-slot:actions>
        <v-btn
          variant="text"
          @click="deleteSnackbar = false"
          icon="mdi-close"
        >
        </v-btn>
      </template>
    </v-snackbar>

    <v-snackbar
      v-model="createSnackbar"
      color="green-lighten-3"
      timeout="1500"
    >
      Created successfully

      <template v-slot:actions>
        <v-btn
          variant="text"
          @click="createSnackbar = false"
          icon="mdi-close"
        >
        </v-btn>
      </template>
    </v-snackbar>

</template>

<style scoped>

    .v-table, th, td {
        border: 1px solid rgb(238,238,238);
    }

</style>
