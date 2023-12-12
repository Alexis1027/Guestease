<script setup>

    defineOptions({ layout: AdminLayout })
    defineProps({ users: Object })
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    
</script>


<template>
    <Head title="Manage users" />
    <v-container>
        <p class="text-h5">Users</p>
        <v-data-table :items="users"></v-data-table>
    </v-container>
</template>

<style scoped>

    .v-table, th, td {
        border: 1px solid rgb(238,238,238);
    }

</style>
