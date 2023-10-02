<script setup>

    import {ref, defineProps, watch, onMounted} from 'vue'
    import {router} from '@inertiajs/vue3'
    import Layout from '../../Layouts/AdminLayout.vue'
    import DeleteGuestHouseModal from './partials/DeleteGuestHouseModal.vue'
    import EditGuestHouseModal from './partials/EditGuestHouseModal.vue'

    defineProps({guesthouses: Object, newEntry: Object})
    const deleteGuestHouseModal = ref(false)
    const editGuestHouseModal = ref(false)
    const deleteSnackbar = ref(false)
    const createSnackbar = ref(false)
    const entries = [5, 10, 15, 20, 25]
    const entry = ref()
    const guesthouse = ref({})

    function deleteGuesthouse(gh) {
        guesthouse.value = gh
        deleteGuestHouseModal.value = true
    }

    watch(entry, () => {
        router.get(`/admin/manage-guesthouses/${entry.value}`)
    })

    function editGuesthouse(gh) {
        guesthouse.value = gh
        editGuestHouseModal.value = true
    }

    defineOptions({layout: Layout})
</script>




<template>
    <Head title="Manage guest house" />
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
                <th class="text-center">Guest house name</th>
                <th class="text-center">Location</th>
                <th class="text-center">Price</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <v-slide-x-transition class="py-0" group>
                <tr v-for="guesthouse in guesthouses.data" :key="guesthouse.id">
                    <td>{{ guesthouse.id }}</td>
                    <td>{{ guesthouse.owner_id }}</td>
                    <td class="text-red"> <v-img cover class="my-1" :src="`../images/room1.png`"></v-img> </td>
                    <td>{{ guesthouse.title }}</td>
                    <td>{{ guesthouse.location }}</td>
                    <td> {{ '₱'+parseInt(guesthouse.price).toLocaleString() }} </td>
                    <td>
                        <v-btn icon="mdi-pencil" size="small" @click="editGuesthouse(guesthouse)" flat class="bg-grey-lighten-5 me-2 text-blue"></v-btn>
                        <v-btn icon="mdi-delete-outline" @click="deleteGuesthouse(guesthouse)" size="small" flat class="bg-grey-lighten-5 text-red"></v-btn>
                    </td>
                </tr>
            </v-slide-x-transition>
            <tr v-if="guesthouses.data.length <= 0">
                <td class="text-h6" colspan="6">No Guest houses found.</td>
            </tr>
        </tbody>
    </v-table>
    <v-row  class="mt-2">
        <v-col class="d-flex justify-end">
            <Link 
                v-for="link in guesthouses.links" 
                :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                :key="link" 
                :href="link.url"
                v-html="link.label"
                >
            </Link>
        </v-col>
    </v-row>
    
    </v-container>

    <DeleteGuestHouseModal :guesthouse="guesthouse" @showDeleteSuccessfulSnackbar="deleteSnackbar = true" :show="deleteGuestHouseModal" @CloseDialog="deleteGuestHouseModal = false" v-model="deleteGuestHouseModal" />
    <EditGuestHouseModal :guesthouse="guesthouse" :show="editGuestHouseModal" @CloseDialog="editGuestHouseModal = false" v-model="editGuestHouseModal" />

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
