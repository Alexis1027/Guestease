<script setup>

    import {defineEmits, watch, ref} from 'vue'
    import MazCarousel from 'maz-ui/components/MazCarousel'
    import MazCard from 'maz-ui/components/MazCard'
    import {processImages} from '@/utils/imageUtils.js'

    const emit = defineEmits('closeReviewListingModal')
    const prop = defineProps(['show', 'listing'])
    const images = ref(prop.listing ? processImages(prop.listing.images) : null)
    console.log(prop)
    watch(prop.listing, () => {
        images =  processImages(prop.listing.images)
    })
</script>

<template>
    
    <v-dialog
      v-model="prop.show"
      width="auto"
    >
      <v-card>
        {{ images }}
        <MazCarousel>
                        <template #title>
                            <p class="text-h6">Photos</p>
                        </template>
                        <MazCard galleryWidth="100%" :elevation="0" v-for="(item, i) in images" zoom :key="i" :images="[`../images/${images[i]}`]" style="min-width: 250px;">
                        </MazCard>
                    </MazCarousel>
        <v-card-text>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" block @click="emit('closeReviewListingModal')">Close Dialog</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

</template>