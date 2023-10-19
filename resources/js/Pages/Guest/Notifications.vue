<script setup>

    import GuestLayout from '../../Layouts/GuestLayout.vue'
    defineOptions({layout: GuestLayout})

</script>

<template>
    <Head title="Notifications" />
    <v-container>
        <p class="text-h4 my-5">Notifications</p>
        <v-sheet>
            <v-list class="bg-grey-lighten-4">
                <p class="text-red text-center">hard coded pa</p>
                <template v-for="n in 3" :key="n">
                    <v-list-item class="py-4" :value="n+10">
                        <strong>Reservation confirmed.</strong>
                        <p>Your reservation has been confirmed Lorem ipsum dolor sit. .</p>
                        <p style="font-size: 15px; color: grey;">
                            Oct {{ n }}, 2023 at 9:04PM
                        </p>
                        <template v-slot:prepend>
                            <v-icon color="green">mdi-check</v-icon>
                        </template>
                        <template v-slot:append>
                            <v-btn prepend-icon="mdi-trash-can" class="text-none" variant="text" size="small" color="red">Delete</v-btn>
                        </template>
                    </v-list-item>
                    <v-divider/>
                </template>
                <template v-for="n in 2" :key="n">
                    <v-list-item class="py-4" :value="n">
                        <strong>Reservation cancelled.</strong>
                        <p>Your reservation has been cancelled Lorem ipsum dolor sit. .</p>
                        <p style="font-size: 15px; color: grey;">
                            Oct {{ n }}, 2023 at 9:04PM
                        </p>
                        <template v-slot:prepend>
                            <v-icon color="warning">mdi-close</v-icon>
                        </template>
                        <template v-slot:append>
                            <v-btn prepend-icon="mdi-trash-can" class="text-none" variant="text" size="small" color="red">Delete</v-btn>
                        </template>
                    </v-list-item>
                    <v-divider/>
                </template>

                <v-list-item class="py-4" value="bruh">
                    <strong>Reservation deleted.</strong>
                    <p>Your reservation has been deleted Lorem ipsum dolor sit. .</p>
                    <p style="font-size: 15px; color: grey;">
                        Oct {{ n }}, 2023 at 9:04PM
                    </p>
                    <template v-slot:prepend>
                        <v-icon color="error">mdi-trash-can</v-icon>
                    </template>
                    <template v-slot:append>
                        <v-btn prepend-icon="mdi-trash-can" class="text-none" variant="text" size="small" color="red">Delete</v-btn>
                    </template>
                </v-list-item>
            </v-list>
        
        </v-sheet>
    </v-container>
</template>

