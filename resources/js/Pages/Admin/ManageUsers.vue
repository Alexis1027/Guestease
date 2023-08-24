<script setup>

    import {ref, defineProps} from 'vue'
    import Layout from '../../shared/Layout.vue'
    import EditUserModal from '../../components/EditUserModal.vue'
    import DeleteUserModal from '../../components/DeleteUserModal.vue'
    import {format} from 'date-fns'

    const prop = defineProps(['users'])

    const entries = [5, 10, 15, 20]
    const editUserModal = ref(false)
    const deleteUserModal = ref(false)
    defineOptions({layout: Layout})
</script>


<template>
    <Head title="Manage users" />
    
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
                <th class="text-center">Profile</th>
                <th class="text-center">Full name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Contact No.</th>
                <th class="text-center">Role</th>
                <th class="text-center">Created At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in prop.users.data" :key="user.id">
               <td>{{ user.id }}</td>
               <td>
                    <v-avatar>
                        <v-img :src="`../images/profile/${user.profile_pic}`">

                        </v-img>
                    </v-avatar>
               </td>
               <td>{{ user.firstname + ' ' + user.lastname }}</td>
               <td>{{ user.email }}</td>
               <td>{{ user.contact_no ? user.contact_no : 'Not available' }}</td>
               <td> {{ user.role }} </td>
               <td> {{ format(new Date(user.created_at), 'M/dd/yyyy') }} </td>
                <td>
                    <v-btn icon="mdi-pencil" size="small" @click="editUserModal = true" flat class="bg-grey-lighten-5 me-2 text-blue"></v-btn>
                    <v-btn icon="mdi-delete-outline" @click="deleteUserModal = true" size="small" flat class="bg-grey-lighten-5 text-red"></v-btn>
                </td>
            </tr>
        </tbody>
    </v-table>
    <v-row  class="mt-2">
        <v-col class="d-flex justify-end">
            <Link 
                v-for="link in prop.users.links" 
                :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                :key="link" 
                :href="link.url"
                v-html="link.label"
                >
            </Link>
        </v-col>
    </v-row>
    </v-container>

    <EditUserModal :show="editUserModal" @CloseDialog="editUserModal = false" v-model="editUserModal" />
    <DeleteUserModal :show="deleteUserModal" @CloseDialog="deleteUserModal = false" v-model="deleteUserModal" />

</template>

<style scoped>

    .v-table, th, td {
        border: 1px solid rgb(238,238,238);
    }

</style>
