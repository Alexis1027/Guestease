<script setup>

    import AdminLayout from '../../Layouts/AdminLayout.vue';
    defineOptions({ layout: AdminLayout })
    defineProps({ reports: Object })

    const headers = [
        { title: 'ID', align: 'start', key: 'id', value: "id" },
        { title: 'Guest', align: 'start', key: 'title', value: "title" },
        { title: 'Warnings', align: 'start', key: 'actions', value: "actions" },
        { title: 'Actions', align: 'start', key: 'actions', value: "actions" },
    ]

</script>

<template>

    <v-container>
    <v-data-table :items="reports" :headers="headers">
        <template v-slot:item="{ item }">
            <tr>
                <td>{{ item.id }}</td>
                <td>{{ item.guest.firstname + " " + item.guest.lastname }}</td>
                <td>{{ item.warnings }}</td>
                <td>
                    <v-btn @click="handleButtonClick(item)">Action</v-btn>
                </td>
            </tr>
        </template>
    </v-data-table>
        <!-- <v-table :fixed-header="true" height="80vh">
            <thead>
                <tr>
                    <th class="text-center text-h5 text-black" colspan="3">Reported guests</th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-end">Warnings</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="n in 20" :key="n">
                    <td class="text-center">John doe</td>
                    <td class="text-end text-error">{{n}} warnings</td>
                    <td class="justify-center d-flex">
                        <v-btn class="mt-2">View details</v-btn>
                    </td>
                </tr>
            </tbody>
        </v-table> -->
    </v-container>
    
</template>