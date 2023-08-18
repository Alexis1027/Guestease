<script setup>

    import {defineEmits, defineProps} from 'vue'
    const emit = defineEmits('closeOverlay')
    const props = defineProps(['overlay', 'images'])
    const emitcloseOverlay = () => {
        emit('closeOverlay', true)
    }

    const imageLayout = [
        { cols: 4 },
        {
        cols: 8,
        children: [{ cols: 12 }, { cols: 12 }],
        },
        { cols: 6 },
        { cols: 3 },
        { cols: 9 },
    ]


</script>
<template>
    <v-overlay v-model="props.overlay" width="100vw" height="100vh" transition="fab-transition">

    <v-container class="bg-white overlay-container" width="100vw">
            <v-row justify="space-between">
                <v-col class="ms-5"><h1>All Images </h1></v-col>
                <v-col class="justify-end d-flex">
                    <v-btn rounded="xl" color="red" variant="text" size="x-large" @click="emitcloseOverlay()">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
            <v-container>
                <v-row>
                    <template v-for="(image,imgIdx) in imageLayout" :key="imgIdx">
                        <v-col :cols="image.cols">
                            <v-img
                            :src="`../images/${images[imgIdx]}`"
                            cover
                            height="100%"
                            ><h1>{{ imgIdx }}</h1></v-img>
                        </v-col>

                        <v-col v-if="image.children" cols="6" class="d-flex flex-column">
                            <v-row>
                            <v-col v-for="(children,childIdx) in image.children" :key="childIdx" :cols="children.cols">
                                <v-img
                                :src="`https://picsum.photos/500/300?image=${children.cols + childIdx}`"
                                cover
                                height="100%"
                                ></v-img>
                            </v-col>
                            </v-row>
                        </v-col>
                    </template>
                </v-row>
            </v-container>
        </v-container>

    </v-overlay>

</template>

<style scoped>

    .overlay-container {
        max-height: 100vh;
        overflow-y: auto;
    }

</style>