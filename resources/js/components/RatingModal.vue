<script setup>

    import {defineProps, defineEmits} from 'vue'
    const emit = defineEmits('closeReviewModal')
    const emitcloseReviewModal = () => {
        emit('closeReviewModal')
    }
    const props = defineProps(['showReviewModal', 'guesthouse', 'star'])
    const images = []
    const guestHouseImg = props.guesthouse.room_image.split(",")

    guestHouseImg.forEach(img => {
        images.push(img)
    });
    console.log(props)

</script>
<template>
      <v-dialog v-model="props.showReviewModal" width="40vw" transition="scroll-x-transition">
        <v-card>
            <v-card-title>
                <v-row>
                    <v-col cols="4">
                        <v-img :src="`../images/${images[0]}`" width="150"></v-img>
                    </v-col>
                    <v-col class="mt-4">{{ props.guesthouse.room_name }}
                        <p>Rate this place </p>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-item>
                <v-rating v-model="props.star" readonly half-increments color="orange-lighten-2"  @click="showReviewModal = true">
                </v-rating>
            </v-card-item>
            <v-card-text>
                <v-textarea label="Describe your experience (optional)" auto-grow variant="outlined" rows="3" row-height="25" shaped></v-textarea>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn color="red"  @click="emitcloseReviewModal">Close</v-btn>
                <v-btn color="green"  @click="emitcloseReviewModal">Submit</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>