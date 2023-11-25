<script setup>

    import AdminLayout from '../../Layouts/AdminLayout.vue'
    import Chart from 'chart.js/auto'
    import DashboardSheet from './partials/DashboardSheet.vue'
    import { onMounted, ref, defineProps } from 'vue';

    defineOptions({ layout: AdminLayout })
    
    const prop = defineProps([
        'total_users',
        'total_listings',
        'auth',
        'approved_listings',
        'pending_listings',
        'declined_listings',
        'not_available_listings', 
        'available_listings',
        'deleted_listings',
        'guests',
        'admins',
        'owners'
    ])

    const myChartRef = ref(null)
    const listingChart = ref(null)
    const userChart = ref(null)

    onMounted(() => {

        const lstChart = listingChart.value.getContext('2d')
        const usrChart = userChart.value.getContext('2d')
        new Chart(lstChart,{
            type: 'bar',
            data: {
                labels: ['Approved', 'Pending', 'Rejected', 'Available', 'Not available', 'Deleted'],
                datasets: [
                    {
                        label: 'Listings',
                        data: [
                            prop.approved_listings,
                            prop.pending_listings, 
                            prop.declined_listings, 
                            prop.available_listings,
                            prop.not_available_listings,
                            prop.deleted_listings
                        ]
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Listing Statistics'
                    }
                }
            },
        })
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
        <p class="text-h5">Listing statistics</p>
        <v-card height="400px" width="70%" class="bg-white">
            <canvas ref="listingChart"></canvas>
        </v-card>
        <p class="text-h5">User statistics</p>
        <v-card height="400px" width="40%">
                <canvas ref="userChart"></canvas>
        </v-card>
        
    </v-container>
</template>

<style scoped>

    canvas {
        border-left: 3px solid;
        border-color: rgb(42,154,243);
    }    

</style>