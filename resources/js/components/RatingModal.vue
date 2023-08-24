<script setup>

    import {useForm} from '@inertiajs/vue3'
    import {defineProps, defineEmits, onUpdated, ref} from 'vue'

    const emit = defineEmits('closeReviewModal')
    const props = defineProps(['showReviewModal', 'guesthouse', 'star', 'auth'])
    const images = []
    const guestHouseImg = props.guesthouse.room_image.split(",")

    guestHouseImg.forEach(img => {
        images.push(img)
    });

    const emitcloseReviewModal = () => {
        emit('closeReviewModal')
    }

    const rating = ref(props.star)

    onUpdated(() => {
        form.rating = props.star
    })

    const form = useForm({
        user_id: props.auth ? props.auth.user.id : '',
        room_id: props.guesthouse.id,
        review: '',
        rating: '', 
    })

    const submit = () => {
        form.post(`/rooms/rate/${props.guesthouse.id}`)
        emit('closeReviewModal')
    }

</script>
<template>
      <v-dialog v-model="props.showReviewModal" width="40vw" transition="scroll-x-transition">
        <v-form @submit.prevent>
            <v-card>
                <v-card-title>
                    <v-row>
                        <v-col cols="4">
                            <v-img :src="`../images/${images[0]}`" width="150"></v-img>
                        </v-col>
                        <v-col class="mt-4">
                            {{ props.guesthouse.room_name }}
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-item>
                    <v-rating v-model="form.rating" :model-value="props.star" readonly half-increments color="orange-lighten-2"  @click="showReviewModal = true">
                    </v-rating>
                </v-card-item>
                <v-card-text>
                    <v-textarea v-model="form.review" label="Describe your experience (optional)" auto-grow variant="outlined" rows="3" row-height="25" shaped></v-textarea>
                </v-card-text>
                <v-card-actions class="justify-end">
                    <v-btn color="red"  @click="emitcloseReviewModal">Close</v-btn>
                    <v-btn color="green" type="submit" @click="submit">Submit</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>
</template>