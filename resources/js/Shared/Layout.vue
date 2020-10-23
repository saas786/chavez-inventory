<template>
  <v-app>
    <div
    
    >
      <v-app-bar
      dark
      prominent
      :src="app_bar_img_url"
      v-bind:class="[page_status ? '' : 'mb-2' ]"
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
          <v-btn text v-if="$page.props['auth.user']" @click="inertiaVisit('/inventory')">
            Hello, {{ $page.props['auth.user'].name }}
          </v-btn>
        </v-toolbar-items>
      </v-app-bar>
      <v-progress-linear
        v-show="page_status"
        indeterminate
        height="8"
        stream
        color="primary"
      ></v-progress-linear>
    </div>
    <v-main>
      <slot />
    </v-main>
  </v-app>
</template>

<script>

import { Inertia } from '@inertiajs/inertia'
import axios from 'axios'

export default {

  data: () => ({
    'page_status': true,
    'app_bar_img_url': 'https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg',
    'flash_success' : false,
  }),

  mounted(){

    axios.get('https://api.unsplash.com/photos/4IxPVkFGJGI', {
      headers: {
        Authorization: 'Client-ID 3LkI5pmvOcEs72PtTZFbsnoX_n2jDpBDa0JOXh4OJbU',
      },
    }).then( response => {
      this.app_bar_img_url = response.data.urls.full
      this.page_status = false
    })

    Inertia.on('start', event => {
      this.page_status = true;
    })
    Inertia.on('success', event => {
      this.flash_success = !!this.$page.props.flash.success;
      this.page_status = false;
    })
  },

  methods:{
    // inertiaVisit: function ( link ){
    //   Inertia.visit(link);
    // }
  }
}
</script>