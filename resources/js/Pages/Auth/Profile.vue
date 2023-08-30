<script setup>
    import Layout from '../../shared/Layout.vue'
    defineOptions({layout: Layout})
    defineProps({
        auth: Object
    })
</script>

<template>
    <v-row>
        <v-col cols="5" class="justify-center d-flex">
            <v-card width="390" height="250">
                <v-card-item>
                    <v-avatar size="150">
                    <v-img src="../images/Profile/21.png"></v-img>
                </v-avatar>
                <p class="text-h4 ms-6">{{ auth.user.firstname }}</p>
                <p class="text-h6 ms-6">Owner</p>
                </v-card-item>
            </v-card>
        </v-col>
        <v-col cols="7">
            <v-container>
                <p class="text-h4">About {{ auth.user.firstname }}</p>
                <p> <v-icon>mdi-map</v-icon> Lives in {{ auth.user.address }}</p>

                <v-divider class="my-5"/>

                <p class="text-h5 mb-4"> {{ auth.user.firstname }}'s reviews</p>

                <v-row>
                    <v-col cols="6" v-for="n in 4" :key="n">
                        <v-card>
                            <v-card-item>
                                Lorem ipsum dolor awokokaw sijeisij smnmn sit.
                            </v-card-item>
                            <v-list-item prepend-avatar="../images/Profile/21.png" subtitle="August 2023" title="First Lastname">
                            </v-list-item>
                        </v-card>
                    </v-col>
                </v-row>
                

                <v-divider class="my-5"/>

                <p class="text-h5 mb-4"> {{ auth.user.firstname }}'s guest houses</p>

                <div style="width: 300px;">
                    <v-img src="../images/room.png" class="rounded-lg" cover></v-img>
                    <strong>Guest House name</strong>
                    <p>Guest House Location</p>
                </div>

            </v-container>
        </v-col>
    </v-row>

</template>