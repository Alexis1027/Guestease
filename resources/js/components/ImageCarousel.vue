<script setup>

    import {defineProps, defineEmits} from 'vue'

    const p = defineProps(['showImageCarousel'])
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
    <v-dialog
      v-model="p.showImageCarousel"
      width="90vw"
    >
    <v-btn icon="mdi-close" @click="emitCloseImgCarousel"></v-btn>
    <v-carousel
      height="400"
      hide-delimiters
      progress="blue"
    >
      <v-carousel-item
        v-for="(slide, i) in slides"
        :key="i"
      >
        <v-sheet
          height="100%"
        >
          <div class="d-flex fill-height justify-center align-center">
            <div class="text-h2">
              {{ slide }} Slide
            </div>
          </div>
        </v-sheet>
      </v-carousel-item>
    </v-carousel>
    </v-dialog>
  </template>