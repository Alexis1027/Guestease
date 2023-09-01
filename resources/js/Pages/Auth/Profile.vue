<script setup>
    import Layout from '../../shared/Layout.vue'
    defineOptions({layout: Layout})
    defineProps({
        auth: Object,
        user: Object
    })
</script>

<template>
    <v-row justify="center">
        <v-col cols="10">
            <v-container class="bg-white">
                <div class="justify-center d-flex">
                    <v-card width="390" height="250" elevation="0">
                        <v-card-item class="text-center">
                            <v-avatar size="150">
                            <v-img :src="`../images/Profile/${user.profile_pic}`"></v-img>
                        </v-avatar>
                        <p class="text-h4">{{ user.firstname + ' ' + user.lastname }}</p>
                        </v-card-item>
                    </v-card>
                </div>
                <v-divider class="my-5"/>
                <!-- About section -->
                <p class="text-h5">About {{ user.firstname }}</p>
                <v-list-item prepend-icon="mdi-home" :title="`Lives in ${user.address}`">
                </v-list-item>
                <v-list-item prepend-icon="mdi-facebook-messenger">
                    {{ user.firstname + ' ' + user.lastname }}
                </v-list-item>
                <v-list-item prepend-icon="mdi-phone" subtitle="Contact number" :title="user.contact_no">
                </v-list-item>

                <v-divider class="my-5"/>
                <!-- Owner's Guest houses section -->
                <p class="text-h5 mb-4"> {{ user.firstname }}'s guest houses</p>

                <v-row>
                    <v-col cols="4" v-for="n in 4" :key="n">
                        <v-img src="../images/room.png" class="rounded-lg" cover></v-img>
                        <strong>Guest House name</strong>
                        <p>Guest House Location</p>
                    </v-col>
                </v-row>

            </v-container>
        </v-col>
    </v-row>

</template>