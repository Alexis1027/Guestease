<template>
    <v-col cols="3">
        <v-sheet elevation="2" height="100" rounded max-width="800" width="100%">
                <v-container>
                    <slot></slot>
                </v-container>
        </v-sheet>
    </v-col>
</template>

<style scoped>

    .v-sheet {
        border-left: 3px solid;
        border-color: rgb(42,154,243);
    }

</style>