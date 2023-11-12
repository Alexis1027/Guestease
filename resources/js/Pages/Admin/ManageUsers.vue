<script setup>

    import {ref, defineProps, watch} from 'vue'
    import { router } from '@inertiajs/vue3'
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import EditUserDialog from './partials/EditUserDialog.vue'
    import DeleteUserDialog from './partials/DeleteUserDialog.vue'
    import {format} from 'date-fns'
    
    defineOptions({layout: AdminLayout})

    const prop = defineProps(['users'])
    const entries = [5, 10, 15, 20, 25]
    const entry = ref()
    const editUserDialog = ref(false)
    const deleteUserDialog = ref(false)
    const deleteSnackbar = ref(false)
    const user = ref({})

    function deleteUser(usr) {
        user.value = usr
        deleteUserDialog.value = true
    }

    watch(entry, () => {
        router.get(`/admin/manage-users/${entry.value}`)
    })

</script>


<template>
    <Head title="Manage users" />
    
    <v-row justify="space-between">
        <v-col cols="2">
                <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
        </v-col>
        <v-col cols="4">
        <!-- <v-text-field  label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field> -->
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
            <v-slide-x-transition class="py-0" group>
                <tr v-for="user in prop.users.data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>
                        <v-avatar>
                            <v-img :src="`../images/profile/${user.profile_pic}`"></v-img>
                        </v-avatar>
                    </td>
                    <td>{{ user.firstname + ' ' + user.lastname }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.contact_no ? user.contact_no : 'Not available' }}</td>
                    <td> {{ user.role }} </td>
                    <td> {{ format(new Date(user.created_at), 'M/dd/yyyy') }} </td>
                    <td>
                        <v-btn size="small" @click="editUserDialog = true" variant="tonal" class="text-none bg-grey-lighten-5 me-2 text-blue">
                            <v-icon>mdi-pencil</v-icon> Edit
                        </v-btn>
                        <v-btn @click="deleteUser(user)" size="small" variant="tonal" class="text-none bg-grey-lighten-5 text-red">
                            <v-icon>mdi-delete-outline</v-icon> Delete
                        </v-btn>
                        
                    </td>
                </tr>
            </v-slide-x-transition>
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

    <v-snackbar v-model="deleteSnackbar" color="red-lighten-3" timeout="1500">
      Deleted successfully
        <template v-slot:actions>
            <v-btn variant="text" @click="deleteSnackbar = false" icon="mdi-close">
            </v-btn>
        </template>
    </v-snackbar>

    <EditUserDialog :show="editUserDialog" @CloseDialog="editUserDialog = false" v-model="editUserDialog" />
    <DeleteUserDialog :user="user" :show="deleteUserDialog" @showDeleteSuccessfulSnackbar="deleteSnackbar = true" @CloseDialog="deleteUserDialog = false" v-model="deleteUserDialog" />

</template>

<style scoped>

    .v-table, th, td {
        border: 1px solid rgb(238,238,238);
    }

</style>
