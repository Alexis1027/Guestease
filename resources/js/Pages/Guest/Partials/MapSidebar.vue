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
    <v-snackbar v-model="props.mapSnackbar" location="right" transition="scroll-x-reverse-transition" color="white">
    <Link :href="`/room/${props.listing ? props.listing.id : ''}`">
        <v-btn rounded color="blue" id="reserveBtn" width="50%">
            See more
        </v-btn>
    </Link>
        <div class="custom-snackbar-content">
            <div style="height: 300px;">
                <v-carousel show-arrows="hover" color="blue-lighten-4" height="100%">
                    <v-carousel-item height="100%" v-for="image in images" :src="`/images/${image}`" :key="image" cover>
                    </v-carousel-item>
                    <v-btn @click="emitCloseMapSnackbar()" icon="mdi-close" id="closeBtn" size="small"></v-btn>
                </v-carousel>
            </div>
            <v-card>
                <v-card-title>
                    <h3>
                        {{ props.listing ? props.listing.title : '' }}
                    </h3>
                    {{ listing.location }}
                </v-card-title>
                <v-card-text>
                    
                </v-card-text>
            </v-card>
        </div>
    </v-snackbar>
</template>

<style scoped>

    #closeBtn {
        right: 0;
        margin-right: 10px;
        margin-top: 10px;
        position: absolute;
    }

    .custom-snackbar-content {
        width: 35vw;
        max-width: 35vw; /* Set your desired max width */
        max-height: 80vh; /* Set your desired max height */
        overflow-y: auto; /* Add scrollbar when content overflows */
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