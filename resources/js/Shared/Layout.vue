<template>
  <v-app>
    <div>
      <v-app-bar
      dark
      src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
      >
        <v-toolbar-title>Custom Mech KBD</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn @click="inertiaVisit('/')" text>
              Home
          </v-btn>
          <v-btn @click="inertiaVisit('/shop')" text>
              Shop
          </v-btn>
          <v-btn @click="inertiaVisit('/custom')" text>
              Custom
          </v-btn>
          <v-btn @click="inertiaVisit('/about')" text>
              About Us
          </v-btn>
          <v-btn @click="inertiaVisit('/faq')" text>
              FAQ
          </v-btn>
        </v-toolbar-items>
      </v-app-bar>
    </div>
    <v-main>
      <slot/>
    </v-main>
  </v-app>
</template>

<script>

import { Inertia } from '@inertiajs/inertia'

export default {
  methods:{
    inertiaVisit: function ( link ){
      Inertia.visit(link);
    }
  }
}
</script>