<script setup>

    import {ref} from 'vue'
    import {format} from 'date-fns'
    import Layout from '../../Layouts/AdminLayout.vue'

    const entries = [5, 10, 15, 20, 25]
    const entry = ref(5)
    const page = ref(1)
    defineProps({
        requests: Object
    })
    defineOptions({
        layout: Layout
    })

</script>
<template>
    <Head title="Requests"></Head>
    <v-container class="bg-white">
        <v-row justify="space-between">
            <v-col cols="2">
                    <v-select flat variant="solo-filled" v-model="entry" :items="entries" label="No. of entries"></v-select>
            </v-col>
            <v-col cols="4">
            <v-text-field label="Search..." clearable variant="solo-filled" flat :loading="false" rounded></v-text-field>
        </v-col>
        </v-row>
        <p class="text-red">doestn work rn</p>
        <v-table hover class="bg-grey-lighten-5 text-center">
            <thead >
                <tr >
                    <th class="text-center">Request id</th>
                    <th class="text-center">Owner</th>
                    <th class="text-center">Guest house</th>
                    <th class="text-center">Bldg permit</th>
                    <th class="text-center">Owner Profile link</th>
                    <th class="text-center">Date Requested</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="request in requests" :key="request.id">
                    <td>{{ request.id }}</td>
                    <td>{{ request.user.firstname + ' ' + request.user.lastname }}</td>
                    <td><Link :href="`/profile/${request.user.id}`">Profile</Link></td>
                    <td><Link :href="`/profile/${request.user.id}`">Profile</Link></td>
                    <td><Link :href="`/profile/${request.user.id}`">Profile</Link></td>
                    <td>{{ format(new Date(request.created_at), 'MMMM dd, yyyy, hh:mm a') }}  </td>
                    <td>
                        <v-btn icon="mdi-check" size="small" class="text-green bg-grey-lighten-5" flat></v-btn>
                        <v-btn icon="mdi-delete-outline" size="small" class="text-red bg-grey-lighten-5" flat></v-btn>
                        <!-- <v-btn icon="mdi-close" size="small" class="text-blue" flat></v-btn> -->
                        <!-- <v-btn icon="mdi-check" size="small" class="text-green" flat></v-btn> -->
                    </td>
                </tr>
                <tr v-if="requests.length <= 0">
                    <td colspan="8"> No requests.</td>
                </tr>
            </tbody>
        </v-table>
        <v-row  class="mt-2">
            <v-col class="d-flex justify-end">
                <!-- <Link 
                    v-for="link in prop.users.links" 
                    :class="{ 'font-weight-bold' : link.active, 'mx-3' : link.url }" 
                    :key="link" 
                    :href="link.url"
                    v-html="link.label"
                    >
                </Link> -->
                <v-pagination
                v-model="page"
                :length="10"
                :total-visible="4"
                rounded="circle"
                ></v-pagination>
            </v-col>
        </v-row>
    </v-container>
</template>