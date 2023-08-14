<script setup>

    import Layout from '../shared/Layout.vue'
    defineOptions({layout: Layout})
    const items = [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' },
      ]

</script>
<template>
    <v-table hover class="border">
        <thead>
            <tr>
                <th colspan="9" class="text-center text-h5">Reservations</th>
            </tr>
            <tr>
                <th v-for="n in 7" :key="n">LOREM</th>
                <th>
                    <v-menu
                    transition="slide-y-transition"
                    >
                    <template v-slot:activator="{ props }">
                        <v-btn
                        v-bind="props"
                        append-icon="mdi-menu-down"
                        flat
                        >
                        Date
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item
                        v-for="(item, i) in items"
                        :key="i"
                        >
                        <v-btn flat>{{ item.title }}</v-btn>
                        </v-list-item>
                    </v-list>
                    </v-menu>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="n in 5" :key="n">
                <td v-for="n in 7" :key="n">ipsum</td>
                <td>bruh</td>
                <td>
                    <v-btn icon="mdi-delete-outline" size="sm" color="red"></v-btn>
                    <v-btn icon="mdi-close" size="sm" color="orange" class="text-white"></v-btn>
                    <v-btn icon="mdi-check" color="green" size="sm"></v-btn>
                </td>
            </tr>
        </tbody>
    </v-table>
</template>