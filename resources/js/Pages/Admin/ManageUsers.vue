<script setup>

    defineOptions({ layout: AdminLayout })
    defineProps({ users: Object })
    import AdminLayout from '../../Layouts/AdminLayout.vue'

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
                        <td>{{ item.address }}</td>
                        <td>{{ item.phone_number }}</td>
                        <td class="text-capitalize">{{ item.role }}</td>
                        <td>
                            <v-btn class="text-none" color="red" size="small">
                                Ban
                            </v-btn>
                        </td>
                    </tr>
                </template>
            
            </v-data-table>
        </v-card>
    </v-container>
</template>

<style scoped>

    
</style>
