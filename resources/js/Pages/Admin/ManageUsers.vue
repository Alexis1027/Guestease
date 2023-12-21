<script setup>

    defineOptions({ layout: AdminLayout })
    defineProps({ users: Object })
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import {useForm} from '@inertiajs/vue3'
    import {ref} from 'vue'

    const banUserDialog = ref(false)
    const unbanUserDialog = ref(false)
    const snackbar = ref(false)
    const message = ref('')
    const selectedUser = useForm({
        user: null
    })

    function showBanUserDialog(user) {
        selectedUser.user = user
        banUserDialog.value = true
    }

    function showUnbanUserDialog(user) {
        selectedUser.user = user
        unbanUserDialog.value = true
    }

    function banUser() {
        selectedUser.put(`/admin/ban-user/${selectedUser.user.id}`, {
            onSuccess: () => {
                banUserDialog.value = false
                snackbar.value = true
                message.value = 'Successfully banned user'
            }
        })
    }

    function unbanUser() {
        selectedUser.put(`/admin/unban-user/${selectedUser.user.id}`, {
            onSuccess: () => {
                unbanUserDialog.value = false
                snackbar.value = true
                message.value = 'Successfully unbanned user'
            }
        })
    }

    const headers = [
        { title: 'First name', align: 'start', sortable: true, key: 'firstname', value: "firstname" },
        { title: 'Last name', align: 'start', key: 'lastname', value: "lastname" },
        { title: 'Email', align: 'start', key: 'email', value: "email" },
        { title: 'Address', align: 'start', key: 'address', value: "address" },
        { title: 'Phone number', align: 'start', key: 'phone_number', value: "phone_number" },
        { title: 'Role', align: 'start', key: 'role', value: "role" },
        { title: 'Actions', align: 'start', key: 'actions', sortable: false,  value: "actions" },
    ]
    
</script>


<template>
    <Head title="Manage users" />
    <v-container>
        <v-card>
            <v-data-table :items="users" :headers="headers">
                <template v-slot:item="{item}">
                    <tr>
                        <td class="text-capitalize">{{ item.firstname }}</td>
                        <td class="text-capitalize">{{ item.lastname }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.address ? item.adress : 'N/A' }}</td>
                        <td>{{ item.phone_number }}</td>
                        <td class="text-capitalize">{{ item.role }}</td>
                        <td>
                            <v-btn class="text-none" v-if="!item.is_banned" @click="showBanUserDialog(item)" color="red" size="small">
                                Ban
                            </v-btn>
                            <v-btn class="text-none" v-else @click="showUnbanUserDialog(item)" color="red" size="small">
                                Unban
                            </v-btn>
                        </td>
                    </tr>
                </template>
            
            </v-data-table>
        </v-card>

        <v-dialog v-model="banUserDialog"  width="50%">
            <v-card title="Ban user">
                <v-form @submit.prevent>
                    <v-sheet rounded="lg" class="pa-4 text-center">
                        <v-alert icon="mdi-alert" color="red-lighten-4" elevation="2" class="text-start text-error">
                            Are you sure you want to ban this user?
                        </v-alert>
                        <p class="ma-4  text-body-2 text-start">
                            User <br>
                            <strong class="text-h6">{{ selectedUser.user.firstname + ' ' + selectedUser.user.lastname }}</strong>
                        </p>
                        <div class="text-end">
                            <v-btn class="text-none me-4" @click="banUserDialog = false" variant="text" width="90">
                                Cancel
                            </v-btn>
                            <v-btn class="text-none" color="red" type="submit" :loading="selectedUser.processing" @click="banUser"  variant="flat" width="90">
                                Ban
                            </v-btn>
                        </div>
                    </v-sheet>
                </v-form>
            </v-card>
        </v-dialog>
    </v-container>

    <v-dialog v-model="unbanUserDialog" width="50%">
        <v-card title="Unban user">
                <v-form @submit.prevent>
                    <v-sheet rounded="lg" class="pa-4 text-center">
                        <v-alert icon="mdi-alert" color="warning" elevation="2" class="text-start">
                            Do you want to unban this user?
                        </v-alert>
                        <p class="ma-4  text-body-2 text-start">
                            User <br>
                            <strong class="text-h6">{{ selectedUser.user.firstname + ' ' + selectedUser.user.lastname }}</strong>
                        </p>
                        <div class="text-end">
                            <v-btn class="text-none me-4" @click="unbanUserDialog = false" variant="text" width="90">
                                Cancel
                            </v-btn>
                            <v-btn class="text-none" color="red" type="submit" :loading="selectedUser.processing" @click="unbanUser"  variant="flat" width="90">
                                Unban
                            </v-btn>
                        </div>
                    </v-sheet>
                </v-form>
            </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar">
        {{ message }}
    </v-snackbar>

</template>
