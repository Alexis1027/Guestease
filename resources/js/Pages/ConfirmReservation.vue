<script setup>

    import {defineProps} from 'vue'

    const prop = defineProps(['guesthouse'])

    const items = [
        'Paypal',
        'Gcash',
        'Asdssdef',
      ]

</script>

<template>
        <Head title="Confirm Reservation" />

        <v-container>
            <v-row>
                <v-col cols="6">
                    <v-container>
                        <Link :href="`/room/${prop.guesthouse.id}`">
                            <v-btn rounded icon="mdi-keyboard-backspace" flat></v-btn>
                        </Link>
                        <label class="text-h5">Confirm Reservation</label>
                        <p class="text-h6 my-4">Personal Information</p>
                        <v-text-field variant="outlined" color="blue" clearable label="First name"></v-text-field>
                        <v-text-field variant="outlined" color="blue" clearable label="Last name"></v-text-field>
                        <v-text-field variant="outlined" color="blue" clearable label="Email" placeholder="johndoe@gmail.com"></v-text-field>
                        <v-text-field variant="outlined" color="blue" clearable label="First name"></v-text-field>
                        <v-select :items="items" label="Payment process" clearable required variant="outlined"></v-select>
                        <v-btn block color="green">Confirm Reservation</v-btn>
                    </v-container>

                </v-col>
                <v-col cols="6">

                    <v-card class="justify-center text-center mt-6">
                        <v-card width="400" style="margin-left: 16%;">
                            <v-img src="/images/room1.png"></v-img>
                        </v-card>
                        <v-card-title>
                            Guest House {{ prop.guesthouse.room_name }}
                        </v-card-title>
                        <v-card-text>
                            <p>{{ prop.guesthouse.room_details }}</p>
                        </v-card-text>
                        <v-divider/>
                        <v-card-text>
                            Price Details
                            <p>{{ prop.guesthouse.room_price }}</p>

                        </v-card-text>
                    </v-card>

                </v-col>
            </v-row>
        </v-container>

</template>