<!-- <script>
    import Layout from '../shared/Layout.vue'

 export default {
   layout: Layout,
 }
</script> -->
<script setup>

    import Layout from '../shared/Layout.vue'
    import Chart from 'chart.js/auto'
    import { onMounted, ref } from 'vue';
    defineOptions({layout: Layout})
    

    const myChartRef = ref(null)

    onMounted(() => {

        const ctx = myChartRef.value.getContext('2d')

        new Chart(ctx,{
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Acquisitions by year',
                        data: [65, 59, 80, 81, 56, 76, 40],
                    },
                    {
                        label: 'Acquisitions by year',
                        data: [45, 34, 25, 68, 76, 55, 32],
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Chart Title'
                    }
                }
            }
        }
    );
    })

</script>


<template>
    <h1>DASHBOARD</h1>
    <v-container width="400">
        <canvas ref="myChartRef"></canvas>
    </v-container>
</template>

