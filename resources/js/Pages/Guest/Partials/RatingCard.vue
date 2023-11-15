<script setup>

    import {ref, defineProps} from 'vue'
    import {format} from 'date-fns'
    const prop = defineProps(['rating'])
    const star = ref(prop.rating.rating)
</script>
<template>
        <v-card elevation="0" class="bg-grey-lighten-4 rounded-xl">
            <v-card-item>
                <v-list class="bg-grey-lighten-4">
                    <Link :href="`/profile/${prop.rating.user.id}`">
                        <v-list-item
                            :prepend-avatar="`/images/profile/${prop.rating.user.profile_pic}`"
                            :title="prop.rating.user.firstname + ' ' + prop.rating.user.lastname"
                            :subtitle="format(new Date(prop.rating.created_at), 'MMMM dd, yyyy, hh:mm a')">
                        </v-list-item>
                    </Link>
                    <v-list-item>
                        <v-rating
                            half-increments
                            density="compact"
                            color="orange-lighten-2"
                            class="ma-0"
                            v-model="star"
                            readonly>
                        </v-rating>
                    </v-list-item>
                    <v-list-item>
                        <p>{{ prop.rating.review }}</p>
                    </v-list-item>
                </v-list>
            </v-card-item>
        </v-card>
</template>