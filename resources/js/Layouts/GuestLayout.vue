<script setup>

    import {router} from '@inertiajs/vue3'

    const logo = '/images/logo/frlogo-transformed.png'
    function logout() {
        router.post('/logout',[], {
            onSuccess: () => {
                location.href = '/'
                window.history.replaceState({}, document.title, '/')
            }
        })
    }

    defineProps({
        auth: Object
    })

</script>

<template>
    <v-layout>
        <v-app-bar scroll-behavior="elevate" scroll-threshold="438">
            <v-row class="mx-3">
                <v-col cols="10" md="7" sm="7" lg="7">
                    <Link href="/" class="font-weight-bold">
                        <v-img :src="logo" height="55" width="260" cover></v-img>
                    </Link>
                </v-col>
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
                <v-col cols="1" sm="1" md="1" lg="1" xl="1" xxl="1" id="home">
                    <Link href="/">
                        <v-btn :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none', 'mt-2 ms-6']">Home</v-btn>
                    </Link>
                </v-col>
                <v-col cols="1" sm="1" md="1" lg="1" xl="1" xxl="1" id="about">
                    <Link href="/about">
                        <v-btn id="about" :class="[$page.component == 'About' ? 'text-blue' : '', 'text-none', , 'mt-2']">About</v-btn>
                    </Link>
                </v-col>
                <v-col cols="1" sm="1" md="1" lg="1" xl="1" xxl="1" id="contactus">
                    <Link href="/contact-us">
                        <v-btn id="contactus" :class="[$page.component == 'ContactUs' ? 'text-blue' : '', 'text-none', , 'mt-2']">Contact Us</v-btn>
                    </Link>
                </v-col>
                <v-col cols="2" sm="2" md="2" lg="2" xl="1" xxl="1" v-if="!auth">
                    <Link href="/login">
                        <v-btn class="text-none mt-2" color="blue" variant="flat" id="biglogin">
                            Register / Login
                        </v-btn>
                        <v-btn icon="mdi-login" color="blue" id="smalllogin">
                        </v-btn>
                    </Link>
                </v-col>
                <v-col v-else cols="2" sm="1" md="1" lg="1" xl="1" xxl="1" class="mt-1">
                    <v-menu min-width="200px" rounded>
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
                                    <div id="default">
                                        <Link href="/">
                                            <v-btn block variant="text" class="text-none">
                                                Home
                                            </v-btn>
                                        </Link>
                                        <Link href="/about">
                                            <v-btn block variant="text" class="text-none">
                                                About us 
                                            </v-btn>
                                        </Link>
                                        
                                        <Link href="/contact-us">
                                            <v-btn block variant="text"  class="text-none">
                                                Contact us
                                            </v-btn>
                                        </Link>
                                    </div>
                                    <v-divider/>
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
                </v-col>
            </v-row>
<!--             
            <v-toolbar-title>
                <Link href="/" class="font-weight-bold">
                    <v-img :src="logo" height="55" width="260" cover></v-img>
                </Link>
            </v-toolbar-title>
            <v-spacer/>
            <Link href="/">
                <v-btn :class="[$page.component == 'Guest/Index' ? 'text-blue' : '', 'text-none']">Home</v-btn>
            </Link>
            <Link href="/about">
                <v-btn :class="[$page.component == 'About' ? 'text-blue' : '', 'text-none']">About</v-btn>
            </Link>
            <Link href="/contact-us">
                <v-btn :class="[$page.component == 'ContactUs' ? 'text-blue' : '', 'text-none']">Contact Us</v-btn>
            </Link>
            <Link href="/login" v-if="!auth">
                <v-btn class="text-none" color="blue" variant="flat">
                    Register / Login
                </v-btn>
            </Link> -->
            
        </v-app-bar>
        <v-main>
            <slot></slot>
        </v-main>

    </v-layout>
</template>

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
</style>