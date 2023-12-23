<script setup>

    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import Chart from 'chart.js/auto'
    import { onMounted, ref, defineProps } from 'vue';

    defineOptions({ layout: AdminLayout })
    const prop = defineProps([
        'total_users',
        'total_listings',
        'pending_listings',
        'total_reservations',
        'pending_reservations',
        'auth',
        'guests',
        'admins',
        'owners',
        'total_earnings'
    ])

    const userChart = ref(null)

    onMounted(() => {

        const usrChart = userChart.value.getContext('2d')
        
        new Chart(usrChart,{
            type: 'pie',
            data: {
                labels: ['Number of guests', 'Number of admins', 'Number of owners'],
                datasets: [
                    {
                        label: 'Users',
                        data: [
                            prop.guests,
                            prop.admins, 
                            prop.owners,
                        ]
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'User statistics'
                    }
                }
            },
        })
    })

</script>


<template>

    <Head title="Dashboard" />
    <p class="text-h4 text-center my-5 mb-1">Admin dashboard</p>
    <v-container>
        <v-row>
            <v-col cols="11" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Total users" class="bg-white" border-color="blue" elevation="2">
                    {{total_users}}
                </v-alert>
            </v-col>
            <v-col cols="11" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Total listings" class="bg-white" border-color="blue" elevation="2">
                    {{total_listings}}
                </v-alert>
            </v-col>
            <v-col cols="11" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Pending listings" class="bg-white" border-color="blue" elevation="2">
                    {{pending_listings}}
                </v-alert>
            </v-col>
            <v-col cols="11" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Total reservations" class="bg-white" border-color="blue" elevation="2">
                    {{total_reservations}}
                </v-alert>
            </v-col>
            <v-col cols="11" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Pending reservations" class="bg-white" border-color="blue" elevation="2">
                    {{pending_reservations}}
                </v-alert>
            </v-col>
            <v-col cols="11" lg="3" md="3" sm="6" xl="3">
                <v-alert border="start" title="Total earnings" class="bg-white" border-color="blue" elevation="2">
                    ₱{{ parseInt(total_earnings).toLocaleString() }}
                </v-alert>
            </v-col>
        </v-row>
        <p class="text-h5">User statistics</p>
        <v-row>
            <v-col cols="12" lg="6" md="6" sm="12" xl="6">
                <v-card height="400px" width="100%">
                    <canvas ref="userChart"></canvas>
                </v-card>
            </v-col>
        </v-row>
        
    </v-container>
</template>

<style scoped>

    canvas {
        border-left: 3px solid;
        border-color: rgb(42,154,243);
    }    

</style>