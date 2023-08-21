<script setup>

    import {ref} from 'vue'
    import Layout from '../../shared/Layout.vue'
    import CreateGuestHouseModal from '../../components/CreateGuestHouseModal.vue';
    import DeleteGuestHouseModal from '../../components/DeleteGuestHouseModal.vue'
    import EditGuestHouseModal from '../../components/EditGuestHouseModal.vue';
    const createGuestHouseDialog = ref(false)
    const deleteGuestHouseModal = ref(false)
    const editGuestHouseModal = ref(false)

    const entries = [5, 10, 15, 20]

    defineOptions({layout: Layout})
</script>




<template>
    <Head title="Manage guest house" />
       
    <v-btn color="blue" prepend-icon="mdi-home-plus-outline" @click="createGuestHouseDialog = true" class="mb-4 text-none mt-2">New Guest House</v-btn>
    
    <v-container class="bg-white">
        <v-row justify="space-between">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
            <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field>
        </v-col>
        </v-row>
        <v-table hover class="bg-grey-lighten-5 text-center">
        <thead>
            <tr >
                <th class="text-center">Id</th>
                <th class="text-center">Guest house name</th>
                <th class="text-center">Location</th>
                <th class="text-center">Price</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="n in 5" :key="n">
               <td>{{ n }}</td>
               <td>guest house {{ n }}</td>
               <td>some random place {{ n }}</td>
               <td>{{ n*1000 }}</td>
                <td>
                    <v-btn icon="mdi-pencil" size="small" @click="editGuestHouseModal = true" flat class="bg-grey-lighten-5 me-2 text-blue"></v-btn>
                    <v-btn icon="mdi-delete-outline" @click="deleteGuestHouseModal = true" size="small" flat class="bg-grey-lighten-5 text-red"></v-btn>
                </td>
            </tr>
        </tbody>
    </v-table>
    <v-row justify="space-between" class="mt-2">
        <v-col>
            Showing 1 to 4 of 4 entries
        </v-col>
        <v-col cols="3"  class="d-flex justify-end">
            <v-btn flat class="text-none">Previous</v-btn>
            <p class="mt-2">1</p>
            <v-btn flat class="text-none">Next</v-btn>
        </v-col>
    </v-row>
    </v-container>

    <CreateGuestHouseModal :dialog="createGuestHouseDialog" @CloseDialog="createGuestHouseDialog = false" v-model="createGuestHouseDialog" />
    <DeleteGuestHouseModal :show="deleteGuestHouseModal" @CloseDialog="deleteGuestHouseModal = false" v-model="deleteGuestHouseModal" />
    <EditGuestHouseModal :show="editGuestHouseModal" @CloseDialog="editGuestHouseModal = false" v-model="editGuestHouseModal" />

</template>

<style scoped>

    .v-table, th, td {
        border: 1px solid rgb(238,238,238);
    }

</style>
