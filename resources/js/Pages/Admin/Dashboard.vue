<script setup>

    import Layout from '../../shared/Layout.vue'
    import Chart from 'chart.js/auto'
    import DashboardSheet from './partials/DashboardSheet.vue'
    import { onMounted, ref } from 'vue';

    defineOptions({layout: Layout})
    

    const myChartRef = ref(null)

    onMounted(() => {

        const ctx = myChartRef.value.getContext('2d')

        new Chart(ctx,{
            type: 'line',
            data: {
                labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sept'],
                datasets: [
                    {
                        label: 'Total Users',
                        data: [2,5,7,34,34,45,67,34,64]
                    },
                    {
                        label: 'Total Reservations',
                        data: [3,20,29,10,11,32,45,23,55]
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Sales Analytics'
                    }
                }
            },
        }
    );
    })

</script>


<template>

    <Head title="Dashboard" />

    <v-container>
        <p class="text-h5 mb-1">GHRS Dashboard</p>
        <v-row>
                <DashboardSheet id="sheet1">
                    <strong class="">Total Users</strong>
                    <p class="mt-3">
                        10
                    </p>
                </DashboardSheet>
                <DashboardSheet id="sheet1">
                    <strong class="">Total Guest Houses</strong>
                    <p class="mt-3">
                        15
                    </p>
                </DashboardSheet>
                <DashboardSheet id="sheet1">
                    <strong class="">Pending Reservations</strong>
                    <p class="mt-3">
                        0
                    </p>
                </DashboardSheet>
                <DashboardSheet id="sheet1">
                    <strong class="">Total Sales</strong>
                    <p class="mt-3">
                        0
                    </p>
                </DashboardSheet>
        </v-row>
    </v-container>

    <v-container width="400">
        <p class="text-h5 mb-1">Monthly Sales Analytics</p>
            <div class="bg-white">
                <canvas ref="myChartRef"></canvas>
            </div>
    </v-container>
</template>

<style scoped>

    canvas {
        border-left: 3px solid;
        border-color: rgb(42,154,243);
    }    

</style>