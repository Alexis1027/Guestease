<script setup>

    import Layout from '../../Layouts/OwnerLayout.vue'
    import MazCarousel from 'maz-ui/components/MazCarousel'
    import MazCard from 'maz-ui/components/MazCard'
    import {processImages} from '@/utils/imageUtils.js'
    import {ref} from 'vue'
    const props = defineProps(['guesthouse'])
    const images = processImages(props.guesthouse.images)
    defineOptions({
        layout: Layout
    })
    const amenities = JSON.parse(props.guesthouse.amenities)

    const tab = ref(1)

</script>
<template>
    <v-toolbar>
      <v-toolbar-title>Edit Listing</v-toolbar-title>
    </v-toolbar>
    <div class="d-flex flex-row">
        <v-tabs v-model="tab" direction="vertical" color="blue">
            <v-tab value="option-1" class="text-none">
                <v-icon start>mdi-account</v-icon>
                Listing details
            </v-tab>
            <v-tab value="option-2" class="text-none">
                <v-icon start>mdi-lock</v-icon>
                Pricing and availability
                </v-tab>
            <v-tab value="option-3" class="text-none">
                <v-icon start> mdi-access-point</v-icon>
                Policies and rules
            </v-tab>
            
            <v-tab value="option-4" color="red" class="text-none text-red">
                <v-icon start> mdi-delete-outline</v-icon>
                Delete listing
            </v-tab>
            
        </v-tabs>
        <v-window v-model="tab">
            <v-window-item value="option-1">
                <v-card flat>
                    <MazCarousel>
                    <template #title>
                        <p class="text-h6">Photos</p>
                    </template>
                    <MazCard galleryWidth="100%" :elevation="0" v-for="(item, i) in images" zoom :key="i" :images="[`/images/${images[i]}`]" style="min-width: 250px;">
                    </MazCard>
                </MazCarousel>
                <v-divider class="mt-4"/>
                <p class="text-h6">Listing basics</p>
                <v-list width="100%">
                    <v-list-item>
                        Listing title
                        <v-text-field :disabled="true" value="Hello" variant="outlined"></v-text-field>
                    </v-list-item>
                    <v-list-item>
                        Listing description
                        <v-textarea :disabled="true" value="Hello" variant="outlined"></v-textarea>
                    </v-list-item>
                    <v-list-item>
                        Listing location
                        <v-text-field :disabled="true" value="Crodova, Cebu" variant="outlined"></v-text-field>
                    </v-list-item>
                    <v-row class="justify-end d-flex mb-1 me-4">
                        <v-col cols="1">
                            <v-btn color="blue" class="rounded-pill text-none">Save</v-btn>
                        </v-col>
                    </v-row>
                    <v-divider/>
                    <v-list>
                        <p class="text-h6">Properties and rooms</p>
                        <v-list-item>
                            Number of guests
                            <template v-slot:append>
                                <v-btn icon="mdi-plus" flat size="small"></v-btn>
                                0
                                <v-btn icon="mdi-minus" flat size="small"></v-btn>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            Number of bed
                            <template v-slot:append>
                                <v-btn icon="mdi-plus" flat size="small"></v-btn>
                                0
                                <v-btn icon="mdi-minus" flat size="small"></v-btn>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            Number of bathroom
                            <template v-slot:append>
                                <v-btn icon="mdi-plus" flat size="small"></v-btn>
                                0
                                <v-btn icon="mdi-minus" flat size="small"></v-btn>
                            </template>
                        </v-list-item>
                    </v-list>
                    <v-divider/>
                    <p class="text-h6">Amenities</p>
                        <v-container>
                            <v-chip :prepend-icon="item.icon" v-for="item in amenities" :key="item.title" class="mx-2">{{ item.title }}</v-chip>
                            <v-chip prepend-icon="mdi-plus" color="green">Add</v-chip>
                        </v-container>
                </v-list>
                </v-card>
            </v-window-item>
            <v-window-item value="option-2">
                <v-card flat>
                    <v-card-text>
                    <p>
                        Morbi nec metus. Suspendisse faucibus, nunc et pellentesque egestas, lacus ante convallis tellus, vitae iaculis lacus elit id tortor. Sed mollis, eros et ultrices tempus, mauris ipsum aliquam libero, non adipiscing dolor urna a orci. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo. Nunc sed turpis.
                    </p>

                    <p>
                        Suspendisse feugiat. Suspendisse faucibus, nunc et pellentesque egestas, lacus ante convallis tellus, vitae iaculis lacus elit id tortor. Proin viverra, ligula sit amet ultrices semper, ligula arcu tristique sapien, a accumsan nisi mauris ac eros. In hac habitasse platea dictumst. Fusce ac felis sit amet ligula pharetra condimentum.
                    </p>

                    <p>
                        Sed consequat, leo eget bibendum sodales, augue velit cursus nunc, quis gravida magna mi a libero. Nam commodo suscipit quam. In consectetuer turpis ut velit. Sed cursus turpis vitae tortor. Aliquam eu nunc.
                    </p>

                    <p>
                        Etiam ut purus mattis mauris sodales aliquam. Ut varius tincidunt libero. Aenean viverra rhoncus pede. Duis leo. Fusce fermentum odio nec arcu.
                    </p>

                    <p class="mb-0">
                        Donec venenatis vulputate lorem. Aenean viverra rhoncus pede. In dui magna, posuere eget, vestibulum et, tempor auctor, justo. Fusce commodo aliquam arcu. Suspendisse enim turpis, dictum sed, iaculis a, condimentum nec, nisi.
                    </p>
                    </v-card-text>
                </v-card>
            </v-window-item>
            <v-window-item value="option-3">
                <v-card flat>
                    <v-card-text>
                    <p>
                        Fusce a quam. Phasellus nec sem in justo pellentesque facilisis. Nam eget dui. Proin viverra, ligula sit amet ultrices semper, ligula arcu tristique sapien, a accumsan nisi mauris ac eros. In dui magna, posuere eget, vestibulum et, tempor auctor, justo.
                    </p>

                    <p class="mb-0">
                        Cras sagittis. Phasellus nec sem in justo pellentesque facilisis. Proin sapien ipsum, porta a, auctor quis, euismod ut, mi. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nam at tortor in tellus interdum sagittis.
                    </p>
                    </v-card-text>
                </v-card>
            </v-window-item>
            <v-window-item value="option-4">
                <v-card flat>
                    <v-card-text>
                    <p>
                        basta Delete listing tab.
                    </p>
                    
                    </v-card-text>
                </v-card>
            </v-window-item>
        </v-window>
    </div>
</template>

<style scoped>

</style>