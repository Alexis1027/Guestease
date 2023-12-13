<script setup>

    defineOptions({ layout: AdminLayout })
    defineProps({ users: Object })
    import AdminLayout from '../../Layouts/AdminLayout.vue'
    
</script>


<template>
    <Head title="Manage users" />
    <v-container>
        <v-card>
            <v-data-table :items="users"></v-data-table>
        </v-card>
    </v-container>
</template>

<style scoped>

    
</style>
