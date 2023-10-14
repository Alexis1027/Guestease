<script setup>
    import Layout from '../Layouts/Layout.vue'
    defineOptions({layout: Layout})
    defineProps({
        auth: Object,
        user: Object,
        listings: Object
    })


</script>

<template>
    <v-row justify="center">
        
        <v-col cols="10">
            <v-container class="bg-white">
                <v-row>
                    <v-col cols="5">
                        <v-card width="390" height="250" elevation="0">
                        <v-card-item class="text-center">
                            <v-avatar size="150">
                            <v-img :src="`../images/Profile/${user.profile_pic}`"></v-img>
                        </v-avatar>
                        <p class="text-h4">{{ user.firstname + ' ' + user.lastname }}</p>
                        </v-card-item>
                    </v-card>
                
                    </v-col>
                    <v-divider vertical/>
                    <v-col cols="7">
                        <!-- About section -->
                        <v-list height="100%">
                            <v-list-item prepend-icon="mdi-home" :title="`Lives in ${user.address}`">
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-facebook-messenger">
                            {{ user.firstname + ' ' + user.lastname }}
                        </v-list-item>
                        <v-list-item prepend-icon="mdi-phone" subtitle="Contact number" :title="user.contact_no">
                        </v-list-item>
                        </v-list>
                    </v-col>
                </v-row>

                <v-divider class="my-5"/>
                <!-- Owner's Guest houses section -->
                <p class="text-h5 mb-4"> {{ user.firstname }}'s listings </p> 
                <v-row v-if="listings.length > 0">
                    <v-col cols="4" v-for="listing in listings" :key="listing.id">
                        <v-card>
                            <v-img :src="`../images/${JSON.parse(listing.images)[0]}`" class="rounded-lg" cover max-height="300"></v-img>
                            <v-card-text>
                                <strong>{{ listing.title }}</strong>
                                <p>{{ listing.location }}</p>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <p v-else>
                    This user does not have a listing yet.
                </p>

            </v-container>
        </v-col>
    </v-row>

</template>