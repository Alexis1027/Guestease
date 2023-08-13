<script setup>

    const items = [
        'Paypal',
        'Gcash',
        'Asdssdef',
      ]

</script>

<template>

        <v-container>
            <v-row>
                <v-col cols="6">

                    <v-container>
                        <v-btn rounded icon="mdi-keyboard-backspace" flat></v-btn>
                        <label class="text-h5">Confirm Reservation</label>
                        <p class="text-h6 my-4">Personal Information</p>
                        <v-text-field label="First name"></v-text-field>
                        <v-text-field label="First name"></v-text-field>
                        <v-text-field label="First name"></v-text-field>
                        <v-text-field label="First name"></v-text-field>
                        <v-select
                        :items="items"
                        label="Payment process"
                        required
                        ></v-select>
                        <v-btn width="100%" color="green">Confirm Reservation</v-btn>
                    </v-container>

                </v-col>
                <v-col cols="6">

                    <v-card class="justify-center text-center mt-6">
                        <v-card width="400" style="margin-left: 16%;">
                            <v-img src="/images/room1.png"></v-img>
                        </v-card>
                        <v-card-title>
                            Guest House
                        </v-card-title>
                        <v-card-text>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quo, fuga.</p>
                        </v-card-text>
                        <v-card-text>
                            <v-icon color="orange">mdi-star</v-icon>
                            4.00
                        </v-card-text>
                        <v-divider/>
                        <v-card-text>
                            Price Details
                        </v-card-text>
                    </v-card>

                </v-col>
            </v-row>
        </v-container>

</template>