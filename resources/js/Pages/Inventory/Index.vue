<template>
  <v-container pa-12>
    <v-row>
      <v-col cols="6">
        <v-card link>
            <v-img
              src="https://techcrunch.com/wp-content/uploads/2020/01/14.jpg"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.3), rgba(0,0,0,.7)"
              height="100px"
            >
            <v-card-title>Prebuilt Orders</v-card-title>
            </v-img>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card link>
            <v-card-title>Components</v-card-title>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card link>
            <v-card-title>Keyboards</v-card-title>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="6">
        <v-card link>
            <v-card-title>Custom Orders</v-card-title>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
      <v-col>
        <v-card cols="6">
            <v-card-title>Statistics</v-card-title>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'

import InventoryLayout from './../../Shared/InventoryLayout'
import Layout from './../../Shared/Layout'

export default {
  
  layout: (h, page) => {
    return h( Layout, [
      h( InventoryLayout, [page] )
    ])
  },

  methods: {
      inertiaVisit: function( link ){
          Inertia.visit( link );
      }
  }

}
</script>