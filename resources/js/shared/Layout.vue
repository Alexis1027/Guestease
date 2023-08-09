<script setup>

    import {ref} from 'vue'
    import Footer from './Footer.vue';
    // import GuestHouseIndex from '../Pages/GuestHouse/index.vue'
    const sidebar = ref(false)
</script>

<template>
    <v-card>
        <v-layout>
            <v-app-bar>
                <v-app-bar-nav-icon @click="sidebar = !sidebar"></v-app-bar-nav-icon>
                <v-toolbar-title>Logo</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn variant="text" icon="mdi-magnify"></v-btn>
                <v-btn variant="text" icon="mdi-filter"></v-btn>
                <v-btn variant="text" icon="mdi-dots-vertical"></v-btn>
             </v-app-bar>
                <v-navigation-drawer v-model="sidebar" :permanent="true" location="left" temporary>
                    <v-list>
                        <v-list-item
                        prepend-avatar="/images/profile/ambatoPOU.jpg" title="John Doe" subtitle="john@doe.com"
                        ></v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list density="compact" nav >
                        <Link href="/" id="link"><v-list-item prepend-icon="mdi-home" title="Home" value="home"></v-list-item></Link>
                        <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                        <v-list-item prepend-icon="mdi-calendar-check-outline" title="View Reservations" value="View Reservations"></v-list-item>
                        <Link href="/about" id="link"><v-list-item prepend-icon="mdi-information-variant" title="About" value="about"></v-list-item></Link>
                        <Link href="/login" id="link"><v-list-item prepend-icon="mdi-login" title="Login" value="login"></v-list-item></Link>
                    </v-list>
                </v-navigation-drawer>
    
            <v-main>
                <slot>
                    
                </slot>
                <template v-slot:placeholder>
                    <div class="d-flex align-center justify-center fill-height">
                        <v-progress-circular
                        color="grey-lighten-4"
                        indeterminate
                        ></v-progress-circular>
                    </div>
                </template>
            <Footer></Footer>

            </v-main>
        </v-layout>
        
    </v-card>
  </template>

  <style scoped>

  #link {
    text-decoration: none;
  }

  .pill-text-field {
  border-radius: 999px; /* Use a high value to achieve a pill shape */
}

</style>