<script setup>

    import {defineProps, onMounted} from 'vue'
    import { useForm } from '@inertiajs/vue3';
    import {format} from 'date-fns'
    import emailjs from '@emailjs/browser'

    const prop = defineProps(['listing', 'auth', 'guests', 'checkin', 'checkout', 'days'])
    const images = JSON.parse(prop.listing.images)
    const checkinDate = format(new Date(prop.checkin), 'MMM d')
    const checkoutDate = format(new Date(prop.checkout), 'MMM d')

    const form = useForm({
        listing_id: prop.listing.id,
        user_id: prop.auth.user.id,
        payment_process: '',
        status: 'pending',
        checkin: format(new Date(prop.checkin), 'yyyy-MM-dd'),
        checkout: format(new Date(prop.checkout), 'yyyy-MM-dd'),
        guests: prop.guests,
        total: parseInt(prop.listing.price) * parseInt(prop.days),
        days: prop.days
    })
        
    const submit = () => {
        form.post('/reserve')
    }

    onMounted(() => {
        paypal.Buttons({
        style: {
            color:'blue',
            shape:'pill',
            layout: 'horizontal',
            tagline: 'false',
            height: 40
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                    value: '0.01'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                form.status = 'approved'
                emailjs.send('service_kfsphbh', 'template_xzp03ja', 
                {
                    sendername: "Guestease team",
                    to: prop.auth.user.email,
                    subject: "Your reservation has been approved.",
                    replyto: "guestease@team.com",
                    message: "Hello, your reservation has been approved :)"
                }
                , 'eEt-YCYeYc0LoTRxJ').then(() => {
                    alert('Success')
                })
                form.post('/reserve')
            });
        },
        onCancel: function(data) {
            alert('cancelled')
        }
        }).render('#paypal-button-container');
    })

</script>

<template>
        <Head title="Confirm Reservation" />
        <v-container>
            <v-row>
                <v-col cols="7">
                    <v-container>
                        <v-form @submit.prevent>
                            <Link :href="`/room/${prop.listing.id}`">
                                <v-btn rounded icon="mdi-keyboard-backspace" flat></v-btn>
                            </Link>
                            <label class="text-h5 font-weight-bold">Confirm Reservation</label>
                            <p class="text-h6 mt-4 font-weight-bold">Your reservation</p>
                                <v-list>
                                    <v-list-item prepend-icon="mdi-calendar">
                                        <p class="font-weight-bold">Dates</p>
                                        <p>{{ `${checkinDate} - ${checkoutDate}` }} </p>
                                    </v-list-item>
                                    <v-list-item prepend-icon="mdi-account-multiple">
                                        <p class="font-weight-bold">Guests</p>
                                        <p>{{ prop.guests }} guests</p>
                                    </v-list-item>
                                </v-list>
                            <v-divider  class="mb-4"/>
                            <p class="text-h6 mt-4 font-weight-bold">Choose how to pay <span class="text-red font-weight-thin">(doesnt work rn)</span> </p>
                            
                            <v-list>
                                <v-list-item>
                                    <template v-slot:append>
                                        <v-checkbox></v-checkbox>
                                    </template>
                                    <p class="font-weight-bold">Pay in full</p>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </v-list-item>
                                <v-list-item>
                                    <template v-slot:append>
                                        <v-checkbox></v-checkbox>
                                    </template>
                                    <p class="font-weight-bold">Pay part now, Pay part later</p>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                </v-list-item>
                            </v-list>
                            <v-divider/>
                            <v-alert variant="outlined" type="warning" prominent v-model="form.hasErrors">
                                <p class="font-weight-bold">Let's try that again</p>
                                <p>Please check your payment details.</p>
                            </v-alert>
                            <p class="text-h6 my-4 font-weight-bold">Pay with</p>
                            <v-select  
                            :items="['Paypal', 'Gcash']"
                            return-object
                            single-line 
                            :error-messages="form.errors.payment_process" 
                            label="Payment process" 
                            v-model="form.payment_process" 
                            clearable
                            item-title="name"
                            item-value="details"
                            required 
                            variant="outlined">
                            </v-select>
                            
                            <v-btn block color="green" class="mb-4 text-none rounded-pill" :loading="form.processing" @click="submit" type="submit">Confirm</v-btn>
                        </v-form>
                        <div id="paypal-button-container"></div>
                    </v-container>

                </v-col>
                <v-divider vertical></v-divider>
                <v-col cols="5">

                    <v-card class="justify-center" id="card">
                        <v-card width="400" max-height="300" class="mt-4" style="margin-left: 8%;">
                            <v-img :src="`/images/${images[0]}`" cover></v-img>
                        </v-card>
                        <v-card-title class="text-center font-weight-bold">
                            {{ prop.listing.title }}
                        </v-card-title>
                        <v-card-text>
                            <v-icon>mdi-map-marker</v-icon>
                            {{ prop.listing.location }}
                            <p>
                            {{ prop.listing.description }}
                            </p>
                        </v-card-text>
                        <v-divider/>
                        <v-card-text>
                            <p class="font-weight-bold text-center">Price Details</p>
                            <v-list-item>
                                <template v-slot:append>
                                    {{ `₱${(prop.listing.price * prop.days).toLocaleString()}` }}
                                </template>
                                {{ '₱'+ parseInt(prop.listing.price).toLocaleString()  }} x {{prop.days}} days
                            </v-list-item>
                            <v-list-item v-if="prop.days >= 30">
                                <template v-slot:append>
                                    ₱{{  (( prop.listing.price * prop.days) * (prop.listing.monthly_discount / 100)).toLocaleString()  }}
                                </template>
                                Monthly stay discount
                            </v-list-item>
                            <v-divider/>
                            <v-list-item class="font-weight-bold">
                                <template v-slot:append v-if="prop.days >= 30">
                                    {{ `₱${((prop.listing.price * prop.days) - ( prop.listing.price * prop.days) * (prop.listing.monthly_discount / 100)).toLocaleString()}` }}
                                </template>
                                <template v-slot:append v-else>
                                    {{ `₱${((prop.listing.price * prop.days)).toLocaleString()}` }}
                                </template>
                                <p>Total</p>
                            </v-list-item>
                        </v-card-text>
                    </v-card>

                </v-col>
            </v-row>
        </v-container>
</template>

<style scoped>

    #card {
        margin-top: 80px;
    }

</style>