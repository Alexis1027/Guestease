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
            <v-card elevation="0">
                <v-carousel show-arrows="hover" color="blue-lighten-4" height="100%">
                    <v-carousel-item height="200" v-for="image in images" :src="`/images/uploads/${image}`" :key="image" cover>
                    </v-carousel-item>
                    <v-btn @click="emitCloseMapSnackbar()" variant="text" class="text-white" icon="mdi-close" id="closeBtn" size="small"></v-btn>
                </v-carousel>
                <v-card-text>
                    <h4 class="text-center">
                        {{ props.listing ? props.listing.title : '' }}
                    </h4>
                    <v-list-item prepend-icon="mdi-map-marker" subtitle="Location" class="text-capitalize"> {{ listing.location }} </v-list-item>
                    <v-list-item prepend-icon="mdi-currency-usd" subtitle="Price" class="text-capitalize"> {{ listing.price }} </v-list-item>
                </v-card-text>
                    <Link :href="`/room/${props.listing ? props.listing.id : ''}`">
                        <v-btn variant="flat" block color="blue" id="reserveBtn" >
                            Learn more
                        </v-btn>
                    </Link>
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


</style>