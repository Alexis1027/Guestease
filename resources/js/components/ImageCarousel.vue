<script setup>

    import {defineProps, defineEmits} from 'vue'

    const p = defineProps(['showImageCarousel', 'images', 'index'])
    const emit = defineEmits('CloseImgCarousel')

    const emitCloseImgCarousel = () => {
        emit('CloseImgCarousel')
    }

    const slides = [
        'First',
        'Second',
        'Third',
        'Fourth',
        'Fifth',
    ]

</script>
<template>
    <v-dialog v-model="p.showImageCarousel" width="70vw" transition="fab-transition">
        <v-btn icon="mdi-close" @click="emitCloseImgCarousel"></v-btn>
        {{ p.index }}
        <v-carousel height="90vh" hide-delimiters progress="white">
            <v-carousel-item v-for="image in images" :key="image">
                <v-sheet height="100%" width="100%">
                    <v-img :src="`../images/${image}`" cover width="100%" height="100%">
                        <template v-slot:placeholder>
                            <div class="d-flex align-center justify-center fill-height">
                                <v-progress-circular color="grey-lighten-4" indeterminate>
                                </v-progress-circular>
                            </div>
                        </template>
                    </v-img>
                </v-sheet>
            </v-carousel-item>
        </v-carousel>
    </v-dialog>
  </template>