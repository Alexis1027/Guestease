<script setup>

    import {defineProps, onMounted} from 'vue'
    import { useForm } from '@inertiajs/vue3';
    import {format} from 'date-fns'
    import emailjs from '@emailjs/browser'
    import {ref} from 'vue'

    const prop = defineProps(['listing', 'auth', 'guests', 'checkin', 'checkout', 'days'])
    const images = JSON.parse(prop.listing.images)
    const checkinDate = format(new Date(prop.checkin), 'PPP')
    const checkoutDate = format(new Date(prop.checkout), 'PPP')
    const showQRCode = ref(false)

    const form = useForm({
        listing_id: prop.listing.id,
        user_id: prop.auth.user.id,
        payment_process: '',
        payment_screenshot: null,
        status: 'pending',
        checkin: format(new Date(prop.checkin), 'yyyy-MM-dd'),
        checkout: format(new Date(prop.checkout), 'yyyy-MM-dd'),
        guests: prop.guests,
        total: parseInt(prop.listing.price) * parseInt(prop.days),
        days: prop.days,
        discount: prop.listing.monthly_discount,
    })
        
    const submit = () => {
        form.post(`/reserve/${prop.listing.id}`, {
            onSuccess: () => {
                
            }
        })
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
                    message: "Hello, your reservation has been approved."
                }
                , 'eEt-YCYeYc0LoTRxJ').then(() => {
                    alert('Success')
                })
                form.post(`/reserve/${prop.listing.id}`)
            });
        },
        onCancel: function(data) {
            alert('cancelled')
        }
        }).render('#paypal-button-container');
    })

    const screenshotRule = [
        value => {
            if (value.length == 1)  return true
            return  "You must input a screenshot of the payment"
        }
    ]

</script>

<template>
        <Head title="Confirm Reservation" />
        <v-container>
            <v-row>
                <v-col cols="12" md="7" sm="12" lg="7" xl="7" xxl="7">
                    <v-container>
                        <v-form @submit.prevent >
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
                                        <p>{{ prop.guests }} {{ prop.guests <= 1 ? 'guest' : 'guests' }}</p>
                                    </v-list-item>
                                </v-list>
                            <v-divider  class="mb-4"/>
                            <v-alert
                                variant="outlined"
                                type="warning"
                                prominent
                                border="top"
                                color="blue"
                                title=""
                            >
                                <template v-slot:title> 
                                    No refund policy <v-icon>mdi-alert</v-icon>
                                </template>
                                Please note that all transactions are final, and we operate under a strict no refund policy. Once a purchase is made, it cannot be reversed or refunded. We encourage you to review your selection carefully before completing the transaction.
                            </v-alert>

                            <p class="text-h6 mt-4 font-weight-bold">Choose how to pay </p>
                            
                            <v-list>
                                <v-list-item value="Gcash" active-color="blue" @click="form.payment_process = 'Gcash'">
                                    <template v-slot:append>
                                        <v-avatar>
                                            <v-img src="/images/icons/gcash2.png"></v-img>
                                        </v-avatar>
                                    </template>
                                    <p> Pay through Gcash</p>
                                    <p class="text-none text-grey">Lorem ipsum dolor sit amet ndae csmque saepe!</p>
                                </v-list-item>
                                <v-list-item value="Paypal" active-color="blue" class="mt-6" @click="form.payment_process = 'Paypal'" >
                                    <template v-slot:append>
                                        <v-avatar>
                                            <v-img src="/images/icons/paypal2.png"></v-img>
                                        </v-avatar>
                                    </template>
                                    <p> Pay through Paypal</p>
                                    <p class="text-none text-grey">Lorem ipsum dolor sit amet ndae cudwemque saepe!</p>
                                </v-list-item>
                            </v-list>
                            <v-divider class="my-4" />
                            <v-alert variant="outlined" class="my-3" type="warning" prominent v-model="form.hasErrors">
                                <p class="font-weight-bold">Let's try that again</p>
                                <p>Please check your payment details.</p>
                            </v-alert>
                            <div id="paypal-button-container" v-show="form.payment_process == 'Paypal'"></div>
                            <v-btn block color="green" v-show="form.payment_process != 'Paypal'" :disabled="!form.payment_process" class="mb-4 text-none rounded-pill" :loading="form.processing" @click="showQRCode = true" type="submit">Confirm</v-btn>
                        
                        </v-form>
                    </v-container>

                </v-col>
                <v-divider vertical></v-divider>
                <v-col cols="12" md="5" lg="5" xl="5" xxl="5" sm="12">
                    <v-card class="justify-center" id="card">
                        <v-card width="400" max-height="300" class="mt-4" style="margin-left: 8%;">
                            <v-img :src="`/images/uploads/${images[0]}`" cover></v-img>
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

        <v-dialog v-model="showQRCode" width="100%">
            <v-form @submit.prevent>
                <v-card title="Pay through GCash">
                    <v-card-text style="margin: auto">
                        <v-img
                        :width="300"
                        cover
                        :src="`/images/qrcode/${listing.qr_code}`"
                        ></v-img>
                    </v-card-text>
                    <v-card-text>
                        Attach a screenshot
                        <v-file-input :error-messages="form.errors.payment_screenshot" label="Screenshot" v-model="form.payment_screenshot" :rules="screenshotRule"></v-file-input>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn color="primary" @click="showQRCode = false" class="text-none">Cancel</v-btn>
                        <v-btn color="blue" type="submit" class="text-none"  variant="flat" :loading="form.processing" @click="submit">Confirm</v-btn>
                            <!-- <v-btn block color="green" v-show="form.payment_process != 'Paypal'" :disabled="!form.payment_process" class="mb-4 text-none rounded-pill" :loading="form.processing" @click="submit" type="submit">Confirm</v-btn> -->
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>

</template>
