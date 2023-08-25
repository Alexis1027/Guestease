<script setup>

    import {ref, defineProps, watch} from 'vue'
    import {Inertia} from '@inertiajs/inertia'
    import Layout from '../../shared/Layout.vue'
    import CreateGuestHouseModal from '../../components/CreateGuestHouseModal.vue';
    import DeleteGuestHouseModal from '../../components/DeleteGuestHouseModal.vue'
    import EditGuestHouseModal from '../../components/EditGuestHouseModal.vue';
    
    const createGuestHouseDialog = ref(false)
    const deleteGuestHouseModal = ref(false)
    const editGuestHouseModal = ref(false)
    const prop = defineProps(['guesthouses'])
    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)
    const guesthouse = ref({})

    watch(prop.guesthouses.current_page, () => {
        // Inertia.get(`/manage/guesthouses/${entry}`)
    })

    function deleteGuestHouse(id) {
        deleteGuestHouseModal.value = true
        Inertia.delete(`delete/guesthouse/${id}`)
    }

    function showDeleteGuesthouseModal(gh) {
        guesthouse.value = gh
        deleteGuestHouseModal.value = true
    }
    

    defineOptions({layout: Layout})
</script>




<template>
    <Head title="Manage guest house" />
       
    <v-btn color="blue" prepend-icon="mdi-plus-thick" @click="createGuestHouseDialog = true" class="mb-4 text-none mt-2">New Guest House</v-btn>
    
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
                <th class="text-center">Images</th>
                <th class="text-center">Guest house name</th>
                <th class="text-center">Location</th>
                <th class="text-center">Price</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="guesthouse in prop.guesthouses.data" :key="guesthouse.id">
               <td>{{ guesthouse.id }}</td>
               <td class="text-red">e fix unya</td>
               <td>{{ guesthouse.room_name }}</td>
               <td>{{ guesthouse.room_location }}</td>
               <td> {{ guesthouse.room_price }} </td>
                <td>
                    <v-btn icon="mdi-pencil" size="small" @click="editGuestHouseModal = true" flat class="bg-grey-lighten-5 me-2 text-blue"></v-btn>
                    <v-btn icon="mdi-delete-outline" @click="showDeleteGuesthouseModal(guesthouse)" size="small" flat class="bg-grey-lighten-5 text-red"></v-btn>
                </td>
            </tr>
        </tbody>
    </v-table>
    <v-row  class="mt-2">
        <v-col class="d-flex justify-end">
            <Link 
                v-for="link in prop.guesthouses.links" 
                :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                :key="link" 
                :href="link.url"
                v-html="link.label"
                >
            </Link>
        </v-col>
    </v-row>
    
    </v-container>

    <CreateGuestHouseModal :dialog="createGuestHouseDialog" @CloseDialog="createGuestHouseDialog = false" v-model="createGuestHouseDialog" />
    <DeleteGuestHouseModal :guesthouse="guesthouse" :show="deleteGuestHouseModal" @CloseDialog="deleteGuestHouseModal = false" v-model="deleteGuestHouseModal" />
    <EditGuestHouseModal :show="editGuestHouseModal" @CloseDialog="editGuestHouseModal = false" v-model="editGuestHouseModal" />

    <!-- <v-snackbar
      v-model="snackbar"
    >
      {{ text }}

      <template v-slot:actions>
        <v-btn
          color="pink"
          variant="text"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar> -->

</template>

<style scoped>

    .v-table, th, td {
        border: 1px solid rgb(238,238,238);
    }

</style>
