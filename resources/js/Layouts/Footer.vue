<script setup>

    const icons = [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ]

    const links = [
        'Home',
        'About Us',
        'Team',
        'Services',
        'Blog',
        'Contact Us',
      ]

</script>

<template>

    <v-footer  class=" text-center d-flex flex-column" id="footer">
        <v-row justify="center" no-gutters>
            <v-btn v-for="link in links" :key="link" color="white" variant="text" class="mx-2" rounded="xl">
                {{ link }}
            </v-btn>
        </v-row>
        <div>
            <v-btn v-for="icon in icons" :key="icon" class="mx-4" :icon="icon" variant="text" color="blue">
            </v-btn>
        </div>
  
        <div class="pt-0">
            Welcome to our guest house reservation platform! With our user-friendly interface, owners can easily
             list their guest houses or rooms, allowing other users to book and reserve listings seamlessly. 
             Our platform connects guests with a diverse range of accommodations, ensuring a 
             hassle-free booking experience.
        </div>
    
        <v-divider/>
        <div>
            {{ new Date().getFullYear() }} — <strong>Guestease</strong>
        </div>
    </v-footer>
  </template>