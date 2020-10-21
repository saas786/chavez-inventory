<template>
  <v-container>
    <v-row>
      <v-col>
        <v-card>
            <card-title>Components</card-title>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
      <v-col>
        <v-card>
            <card-title>Keyboards</card-title>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-card>
            <card-title>Prebuilt Orders</card-title>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
      <v-col>
        <v-card>
            <card-title>Custom Orders</card-title>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

import InventoryLayout from './../../Shared/InventoryLayout'
import Layout from './../../Shared/Layout'

export default {
  
  layout: (h, page) => {
    return h( Layout, [
      h( InventoryLayout, [page] )
    ])
  },

}
</script>