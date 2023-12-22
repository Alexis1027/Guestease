<script setup>

    import {useForm} from '@inertiajs/vue3'
    import {defineProps, defineEmits, onUpdated, ref} from 'vue'

    const emit = defineEmits('closeReviewModal')
    const props = defineProps(['showReviewModal', 'listing', 'star', 'auth'])
    const images = JSON.parse(props.listing.images)

    const emitcloseReviewModal = () => {
        emit('closeReviewModal')
    }

    const rating = ref(props.star)

    onUpdated(() => {
        form.rating = props.star
    })

    const form = useForm({
        user_id: props.auth ? props.auth.user.id : '',
        listing_id: props.listing.id,
        review: '',
        rating: '', 
    })

    const submit = () => {
        form.post(`/rate-listing/${props.listing.id}`, {
            preserveScroll: true
        })
        emit('closeReviewModal')
    }

</script>
<template>
      <v-dialog v-model="props.showReviewModal" width="auto" transition="scroll-x-transition">
        <v-form @submit.prevent>
            <v-card>
                <v-card-title>
                    <v-row>
                        <v-col cols="4">
                            <v-img :src="`/images/uploads/${images[0]}`" width="100%" max-height="200"></v-img>
                        </v-col>
                        <v-col class="mt-4">
                            {{ props.listing.title }}
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-item>
                    <v-rating v-model="form.rating" :model-value="props.star" readonly half-increments color="orange-lighten-2"  @click="showReviewModal = true">
                    </v-rating>
                </v-card-item>
                <v-card-text>
                    <v-textarea v-model="form.review"  @keydown.enter="submit" label="Describe your experience (optional)" auto-grow variant="outlined" rows="3" row-height="25" shaped></v-textarea>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <v-btn color="red"  @click="emitcloseReviewModal">Close</v-btn>
                    <v-btn color="green" type="submit" @click="submit" :disabled="form.processing" :loading="form.loading">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>