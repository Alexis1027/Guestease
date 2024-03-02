<script setup>

    defineOptions({ layout: GuestLayout })
    import GuestLayout from '../Layouts/GuestLayout.vue'
    import Footer from '../Layouts/Footer.vue'

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
        <v-col cols="12" sm="6" md="4" lg="3">
            <v-card elevation="0">
                <v-img src="https://scontent.fceb2-2.fna.fbcdn.net/v/t1.15752-9/412100779_372115435336730_2736720546339065577_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=8cd0a2&_nc_eui2=AeHwlvERtohPkE5UneYd6fd0WAnInhNRfKtYCcieE1F8q7AAb_lxlNQ58UKyZesvII1CNvHKVDiv18ICJ2iPctOp&_nc_ohc=g528GUs4R6wAX_0hegR&_nc_ht=scontent.fceb2-2.fna&oh=03_AdTxbP_VL_KrQ4N_9kJrB3lmUZuEZH4nB1i1J_x2640eWQ&oe=65F7C165" cover height="300"></v-img>
                <v-card-title>Joyce Degamo</v-card-title>
                <v-card-text>Project Manager</v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4" lg="3">
            <v-card elevation="0">
                <v-img src="https://scontent.fceb2-1.fna.fbcdn.net/v/t1.15752-9/409626125_1530087361136538_3691217215965944978_n.jpg?_nc_cat=106&ccb=1-7&_nc_sid=8cd0a2&_nc_eui2=AeFIi4QjceXeSdi2xOA_lsOnAw40feHjb8MDDjR94eNvwxCYzQtOQ7RkK-bLda29oZs0Sk0bExh5KjPhEi549KOo&_nc_ohc=EJKR5y3mN3sAX9L-eg_&_nc_ht=scontent.fceb2-1.fna&oh=03_AdQ11NyyQiG_eufYqcGQ6TpN1ibwV5Jgcy5xcdXJi0eJCA&oe=65F7E75F" cover height="300"></v-img>
                <v-card-title>Stephen Heiward Samson</v-card-title>
                <v-card-text>ERD / Tester</v-card-text>
            </v-card>
        </v-col>

        <v-col cols="12" sm="6" md="4" lg="3">
            <v-card elevation="0">
                <v-img src="https://scontent.fceb2-2.fna.fbcdn.net/v/t1.15752-9/371510790_1488188901973155_7463232296933041028_n.png?_nc_cat=104&ccb=1-7&_nc_sid=8cd0a2&_nc_eui2=AeGZZ_3MSLgfB-alGNGtKjA5fN3iaWMEtfB83eJpYwS18DWHbQ9EWJqvvoPm-JB-Vr4VyFjhGlByDxVud7TWWBoA&_nc_ohc=5a_5bKHqSzMAX9oY2cj&_nc_ht=scontent.fceb2-2.fna&oh=03_AdS7sJrASmAUfbHuO5FiwJzOnftpYgLHfkWaq33Dh-PXKA&oe=65F7DAC1" cover height="300"></v-img>
                <v-card-title>Fiel Boy Aton</v-card-title>
                <v-card-text>Frontend/Backend Developer</v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" sm="6" md="4" lg="3">
            <v-card elevation="0">
                <v-img src="https://scontent.fceb2-2.fna.fbcdn.net/v/t1.15752-9/385537008_895382418926743_1792330941274177686_n.png?_nc_cat=104&ccb=1-7&_nc_sid=8cd0a2&_nc_eui2=AeGVYEdtOQe__SdQWwbm2Nzpi5AfAsxWA2KLkB8CzFYDYvMeuS3NoSmHVsixt7WzaRbhpId_xQyRrMWAAU_d2dYw&_nc_ohc=7Ws5-SB9pB8AX-UOTlT&_nc_ht=scontent.fceb2-2.fna&oh=03_AdS91bpELl8uFg-4QuxkcEYowVIeb1iCusO153tzKWMZkA&oe=65F7C174" cover height="300"></v-img>
                <v-card-title>Alexis Jumao-as</v-card-title>
                <v-card-text>Frontend/Backend Developer</v-card-text>
            </v-card>
        </v-col>
    </v-row>

    <Footer/>

</template>