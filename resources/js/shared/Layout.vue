<script setup>

    import {Link} from '@inertiajs/vue3'
    // import GuestHouseIndex from '../Pages/GuestHouse/index.vue'
</script>

<template>
    <v-card>
        <v-layout>
            <v-navigation-drawer
            expand-on-hover
            rail
            :permanent="true"
            >
            <v-list>
                <v-list-item
                prepend-avatar="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR3W_QY2mjCczbcim1BxtkVGA87l7EX2SYOTg&usqp=CAU"
                title="John Doe"
                subtitle="john@doe.com"
                ></v-list-item>
            </v-list>
    
            <v-divider></v-divider>
    
            <v-list density="compact" nav>
                <Link href="/"><v-list-item prepend-icon="mdi-home" title="Home" value="home"></v-list-item></Link>
                <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                <v-list-item prepend-icon="mdi-calendar-check-outline" title="View Reservations" value="View Reservations"></v-list-item>
                <Link href="/about"><v-list-item prepend-icon="mdi-information-variant" title="About" value="about"></v-list-item></Link>
            </v-list>
            </v-navigation-drawer>
    
            <v-main>
                <!-- <GuestHouseIndex/> -->
                <slot/>
            </v-main>
        </v-layout>
    </v-card>
  </template>