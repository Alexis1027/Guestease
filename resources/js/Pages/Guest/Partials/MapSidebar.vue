<script setup>

    import {ref, defineProps, defineEmits, watch} from 'vue'
    const props = defineProps(['mapSnackbar', 'listing'])
    const emit = defineEmits('closeMapSnackbar')
    var images
    watch(props, () => {
        console.log(props.listing)
        images = JSON.parse(props.listing.images)
    })  

    const emitCloseMapSnackbar = () => {
        emit('closeMapSnackbar')
    }

</script>

<template>
    <v-snackbar v-model="props.mapSnackbar" location="top right" transition="scroll-x-reverse-transition" color="white" style="margin-top: 5%;">
        <div class="custom-snackbar-content" >
            <v-card width="100%" elevation="0">
                <v-carousel show-arrows="hover" color="blue-lighten-4" height="100%">
                    <v-carousel-item height="200" v-for="image in images" :src="`/images/uploads/${image}`" :key="image" cover>
                    </v-carousel-item>
                    <v-btn @click="emitCloseMapSnackbar()" variant="text" class="text-white" icon="mdi-close" id="closeBtn" size="small"></v-btn>
                </v-carousel>
                <v-card-text>
                    <h4>
                        {{ props.listing ? props.listing.title : '' }}
                    </h4>
                    {{ listing.location }}
                </v-card-text>
                <v-card-actions>
                    <v-spacer/>
                    <Link :href="`/room/${props.listing ? props.listing.id : ''}`">
                        <v-btn rounded color="blue" id="reserveBtn" width="50%">
                            See more
                        </v-btn>
                    </Link>
                </v-card-actions>
            </v-card>
        </div>
    </v-snackbar>
</template>

<style scoped>

    #closeBtn {
        right: 0;
        /* margin-right: 10px; */
        margin-top: 10px;
        position: absolute;
    }

    #reserveBtn {
        bottom: 0; 
        position: absolute; 
        z-index: 99; 
        right: 0; 
        margin-bottom: 20px;
        margin-right: 36px;
    }

</style>