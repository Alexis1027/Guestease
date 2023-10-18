<script setup>
    const logo = '/images/logo/frlogo.png'
    defineProps({
        auth: Object
    })
</script>
<template>
    
    <v-layout>
        <v-app-bar scroll-threshold="438">
            <v-toolbar-title>
                <Link class="font-weight-bold">
                    <v-img :src="logo" height="55" width="260" cover></v-img>
                </Link>
            </v-toolbar-title>
            <v-divider vertical />
            <Link href="/owner/dashboard">
                <v-btn class="text-none rounded-pill ms-2" :color="$page.component == 'Owner/Dashboard' ? 'blue' : ''">
                    Dashboard
                </v-btn>
            </Link>
            <Link href="/owner/listings">
                <v-btn class="text-none rounded-pill" :color="$page.component == 'Owner/Listing' ? 'blue' : ''">
                    Listings
                </v-btn>
            </Link>
            <Link href="/owner/reservations">
                <v-btn class="text-none rounded-pill" :color="$page.component == 'Owner/Reservations' ? 'blue' : ''">
                    Reservations
                </v-btn>
            </Link>
            <Link href="/owner/calendar">
                <v-btn class="text-none rounded-pill" :color="$page.component == 'Owner/Calendar' ? 'blue' : ''">Calendar</v-btn>
            </Link>
            
            <v-spacer/>

            <v-spacer/>

            <v-menu min-width="200px" rounded>
                <template v-slot:activator="{ props }">
                    <v-btn class="text-none" icon v-bind="props" >
                        <v-badge content="6" color="error">
                            <v-icon>mdi-bell-outline</v-icon>
                        </v-badge>
                    </v-btn>
                </template>
                <v-card width="450">
                    <v-toolbar>
                        <v-toolbar-title>Notifications</v-toolbar-title>
                    </v-toolbar>
                    <v-list>
                        <p class="text-red ms-5">doestn work</p>
                        <v-list-item :value="n" v-for="n in 6" :key="n"
                            class="py-2"
                            prepend-avatar="../images/profile/21.png" 
                            title="John Doe reserved at your place."
                            :subtitle="`${n+1} hours ago`">
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
            <v-menu  min-width="200px" rounded>
                <template v-slot:activator="{ props }">
                <v-btn icon v-bind="props">
                    <v-avatar size="small">
                        <v-img :src="`../images/profile/${auth.user.profile_pic}`"></v-img>
                    </v-avatar>
                </v-btn>
                </template>
                <v-card width="250">
                    <div class="mx-auto text-center">
                        <Link :href="`/profile/${auth.user.id}`">
                            <v-btn variant="text" block class="text-none">
                                Profile
                            </v-btn>
                        </Link>
                        <Link href="/account">
                            <v-btn  variant="text" block class="text-none">
                                Account
                            </v-btn>
                        </Link>
                        
                        <v-divider/>
                        <Link href="/logout" method="post">
                            <v-btn variant="text" color="red" block class="text-none">
                                Logout
                            </v-btn>
                        </Link>
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