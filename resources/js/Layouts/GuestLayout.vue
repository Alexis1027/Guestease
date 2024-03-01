<script setup>

    import {router, useForm} from '@inertiajs/vue3'
    import { ref } from 'vue'
    import { format } from 'date-fns'

    const searchDialog = ref(false)
    const logo = '/images/logo/frlogo-transformed.png'
    const smallLogo = '/images/logo/small.png'
    function logout() {
        router.post('/logout')
    }
    const checkinMenu = ref(false)
    const checkoutMenu = ref(false)
    
    const searchForm = useForm({
        type: 'Any',
        checkin_date: null,
        checkout_date: null,
        people: 1
    })

    function search() {
        searchForm.get('/search', {
            onSuccess: () => {
                searchDialog.value = false
            }
        })
    }

    defineProps({ auth: Object })

</script>

<template>
    <v-layout>
        <v-app-bar>

            <v-app-bar-title>
                <Link href="/">
                    <v-img :src="smallLogo" height="55" width="260" contain v-if="$vuetify.display.width <= 450"></v-img>
                    <v-img :src="logo" height="55" width="260" contain v-else></v-img>
                </Link>
            </v-app-bar-title>
            <template v-slot:append>
                <v-btn @click="searchDialog = true" class="mt-2 text-none" icon="mdi-magnify" v-if="$vuetify.display.width <= 800"></v-btn>
                <v-btn @click="searchDialog = true" class="mt-2 text-none" prepend-icon="mdi-magnify" v-else :variant="$page.component == 'Guest/Search' ? 'tonal' : ''" :class="[$page.component == 'Guest/Search' ? 'text-blue' : '', 'text-none', 'mt-2']">Search</v-btn>
                <Link href="/">
                    <v-btn  icon="mdi-home" color="blue" v-if="$vuetify.display.width <= 750" ></v-btn>
                    <v-btn prepend-icon="mdi-home" v-else :variant="$page.component == 'Guest/Index' ? 'tonal' : ''" :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none', 'mt-2']">Home</v-btn>
                </Link>
                <Link href="/about">
                    <v-btn  icon="mdi-information-variant" color="red" v-if="$vuetify.display.width <= 750" ></v-btn>
                    <v-btn prepend-icon="mdi-information-variant"  v-else  :variant="$page.component == 'About' ? 'tonal' : ''" :class="[$page.component == 'About' ? 'text-blue' : '', 'text-none', 'mt-2']">About</v-btn>
                </Link>
                <Link href="/contact-us">
                    <v-btn  icon="mdi-phone" color="blue" v-if="$vuetify.display.width <= 750" ></v-btn>
                    <v-btn prepend-icon="mdi-phone" v-else :variant="$page.component == 'ContactUs' ? 'tonal' : ''" :class="[$page.component == 'ContactUs' ? 'text-blue' : '', 'text-none', 'mt-2']">Contact Us</v-btn>
                </Link>
                <div v-if="!auth">
                    <Link href="/login">
                        <v-btn  icon="mdi-login" color="blue" v-if="$vuetify.display.width <= 750" ></v-btn>
                        <v-btn prepend-icon="mdi-login" class="text-none mt-1" color="blue" variant="flat" v-else>
                            Register / Login
                        </v-btn>
                    </Link>
                </div>

                <v-menu min-width="200px" rounded v-else>

                    <template v-slot:activator="{ props }">
                        <v-btn class="border" size="large" v-bind="props">
                            <template v-slot:prepend>
                                <v-avatar color="blue-lighten-3" size="35">
                                    <v-img :src="`../images/profile/${auth.user.profile_pic}`"></v-img>
                                </v-avatar>
                            </template>
                            <v-icon>mdi-menu</v-icon>
                        </v-btn>
                    </template>

                    <v-card width="250">
                        <v-card-item>
                            <div class="mx-auto">
                                <Link href="/reservations">
                                    <v-btn block variant="text" class="text-none">
                                        Reservations
                                    </v-btn>
                                </Link>
                                <Link href="/wishlists">
                                    <v-btn block variant="text" class="text-none">
                                        Wishlists 
                                    </v-btn>
                                </Link>
                                
                                <Link href="/account">
                                    <v-btn block variant="text"  class="text-none">
                                        Account
                                    </v-btn>
                                </Link>
                                <v-divider/>
                                
                                <Link @click="logout" method="post">
                                    <v-btn block variant="text" color="red" class="text-none">
                                        Logout
                                    </v-btn>
                                </Link>
                            </div>
                        </v-card-item>
                    </v-card>
                </v-menu>
            </template>
        </v-app-bar>
        <v-main>
            <slot></slot>
        </v-main>
        <v-dialog v-model="searchDialog">
            <v-card title="Search for a stay">
                <v-card-item>
                    <v-row class="my-2">
                        <v-col md="4">
                            <v-select variant="outlined" color="blue" v-model="searchForm.type" :items="['Any', 'Guest house', 'Room']" label="Type of place"></v-select>
                        </v-col>
                        <v-col md="4">
                            <v-row>
                                <v-col cols="6">
                                    <v-menu v-model="checkinMenu" location="end" :close-on-content-click="false">
                                        <template v-slot:activator="{ props }">
                                            <v-text-field variant="outlined" color="blue" readonly :error-messages="searchForm.errors.checkin_date" label="Check in" v-model="searchForm.checkin_date" v-bind="props"></v-text-field>
                                        </template>
                                        <v-card min-width="300">
                                            <v-date-picker v-model="searchForm.checkin_date"></v-date-picker>
                                        </v-card>
                                    </v-menu>
                                    <!-- <v-text-field label="Where are you going?" v-bind="props"></v-text-field> -->
                                </v-col>
                                <v-col cols="6">
                                    <v-menu v-model="checkoutMenu" location="end" :close-on-content-click="false">
                                        <template v-slot:activator="{ props }">
                                            <v-text-field variant="outlined" color="blue" readonly :error-messages="searchForm.errors.checkout_date" v-model="searchForm.checkout_date" label="Check out" v-bind="props"></v-text-field>
                                        </template>
                                        <v-card min-width="300">
                                            <v-date-picker v-model="searchForm.checkout_date" ></v-date-picker>
                                        </v-card>
                                    </v-menu>
                                </v-col>
                            </v-row>
                           
                        </v-col>
                        <v-col cols="4">
                            <v-text-field label="How many guests?" variant="outlined" color="blue" type="number" v-model="searchForm.people"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-item>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="searchDialog = false">Cancel</v-btn>
                    <v-btn variant="flat" prepend-icon="mdi-magnify" color="blue" @click="search">Search</v-btn>
                </v-card-actions>            
            </v-card>
        </v-dialog>
    </v-layout>
</template>
<!-- 
<style scoped>

    #small {
        display: none;
    }

    #default {
        display: none;
    }

    #smalllogin {
        display: none;
    }

    @media (max-width: 700px) {

        #biglogin {
            display: none;
        }

        #smalllogin {
            display: block;
        }

        #about {
            display: none;
        }

        #home {
            display: none;
        }

        #contactus {
            display: none;
        }

        #default {
            display: block;
        }

    }
</style> -->