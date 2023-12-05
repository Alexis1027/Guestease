<script setup>

    import GuestLayout from '../Layouts/GuestLayout.vue'
    import Footer from '../Layouts/Footer.vue'
    defineOptions({layout: GuestLayout})

</script>

<template>
    <Head title="About" />
  <v-parallax src="https://news.airbnb.com/wp-content/uploads/sites/4/2022/09/Newsroom-About.jpg?w=1536"></v-parallax>
    <div class="text-center justify-center d-flex my-6">
        <v-card elevation="0" width="600">
            <p class="text-h4">About us</p>
            <p>
                At <strong>Guestease</strong>, we're passionate about providing you with unforgettable stays. 
                We offer a curated selection of accommodations tailored to your preferences. 
                
                Our goal is to ensure your comfort and satisfaction. With a focus on 
                personalized service, we're here to make your travel experience exceptional.
                Welcome to <strong>Guestease</strong>, where your stay is our priority.
            </p>
        </v-card>
    </div>

    <v-divider class="my-4" />

    <p class="text-h4 text-center my-3">Founders</p>
    <v-row class="mx-5">
        <v-col cols="3">
            <v-card elevation="0">
                <v-img src="images/Profile/21.png" cover height="300"></v-img>
                <v-card-title>21 Savage</v-card-title>
                <v-card-text>Lorem ipsum dolor sit.</v-card-text>
            </v-card>
        </v-col>
        <v-col cols="3">
            <v-card elevation="0">
                <v-img src="https://assets.vogue.com/photos/63d7d0e493244f4c6f672dec/master/w_2560%2Cc_limit/image00011.jpeg" cover height="300"></v-img>
                <v-card-title>Ice</v-card-title>
                <v-card-text>Lorem ipsum dolor sit.</v-card-text>
            </v-card>
        </v-col>
        
        <v-col cols="3">
            <v-card elevation="0">
                <v-img src="https://media.gq.com.mx/photos/6271a368d02f450ef6d64cd6/1:1/w_2092,h_2092,c_limit/nacho%20varga.jpg" cover height="300"></v-img>
                <v-card-title>Nacho</v-card-title>
                <v-card-text>Lorem ipsum dolor sit.</v-card-text>
            </v-card>
        </v-col>
        <v-col cols="3">
            <v-card elevation="0">
                <v-img src="https://assets.teenvogue.com/photos/641caf88cc857e1ab2e31f28/16:9/w_2560%2Cc_limit/1412528224" cover height="300"></v-img>
                <v-card-title>Chae</v-card-title>
                <v-card-text>Lorem ipsum dolor sit.</v-card-text>
            </v-card>
        </v-col>
    </v-row>

    <Footer/>

</template>


