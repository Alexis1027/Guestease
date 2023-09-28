<script setup>
    const logo = '/images/logo/frlogo.png'
    defineProps({
        auth: Object
    })
</script>
<template>
    
    <v-layout>
        <v-app-bar scroll-behavior="elevate" scroll-threshold="438">
            <v-toolbar-title>
                <Link href="/" class="font-weight-bold">
                    <v-img :src="logo" height="55" width="260" cover></v-img>
                </Link>
            </v-toolbar-title>
            <v-spacer/>
            <v-btn class="text-none rounded-pill">Listing</v-btn>
            <v-btn class="text-none rounded-pill">Calendar</v-btn>
            <v-btn class="text-none rounded-pill">Reservations</v-btn>
            <v-spacer/>

            <v-btn icon>
                <v-icon>mdi-bell-outline</v-icon>
            </v-btn>
            <v-menu
        min-width="200px"
        rounded
      >
        <template v-slot:activator="{ props }">
          <v-btn
            icon
            v-bind="props"
          >
            <v-avatar size="small">
                <v-img :src="`../images/profile/${auth.user.profile_pic}`"></v-img>
            </v-avatar>
          </v-btn>
        </template>
        <v-card width="250">
            <div class="mx-auto text-center">
                <v-btn variant="text" block class="text-none">
                    Profile
                </v-btn>
                <v-btn  variant="text" block class="text-none">
                    Account
                </v-btn>
                <v-divider/>
                <v-btn variant="text" block class="text-none">
                    Logout
                </v-btn>
            </div>
        </v-card>
      </v-menu>

        </v-app-bar>
        <v-main>
            <v-container>   
                <slot>
                </slot>
            </v-container>
        </v-main>
    </v-layout>
</template>