<script setup>

    import Layout from '../../shared/Layout.vue'
    defineOptions({layout: Layout})
</script>




<template>
    <Head title="Manage guest house" />
       

    <v-row justify="end">
        <v-col cols="1">
            <Link href="/create/guesthouse">
                <v-btn color="green" class="mt-2">New </v-btn>
            </Link>
        </v-col>
        <v-col cols="4">
            <v-text-field  label="Search guest house..." clearable variant="solo-filled" :loading="false" rounded></v-text-field>
        </v-col>
    </v-row>
    <v-table hover class="border">
        <thead>
            <tr>
                <th colspan="9" class="text-center text-h5">Guest houses</th>
            </tr>
            <tr>
                <th>id</th>
                <th>guest house</th>
                <th>location</th>
                <th>price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="n in 5" :key="n">
               <td>{{ n }}</td>
               <td>guest house {{ n }}</td>
               <td>some random place {{ n }}</td>
               <td>{{ n*1000 }}</td>
                <td>
                    <v-btn icon="mdi-pencil" size="sm" color="blue-lighten-3" class="me-2 text-white"></v-btn>
                    <v-btn icon="mdi-delete-outline" size="sm" color="red"></v-btn>
                </td>
            </tr>
        </tbody>
    </v-table>

</template>

