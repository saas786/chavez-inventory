<template>
  <v-container pa-12>
    <v-row>
      <v-col cols="6">
        <v-card link height="100%">
            <v-img
              :src="imgs[0]"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
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
            <v-img
              :src="imgs[1]"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="100px"
            >
              <v-card-title>Components</v-card-title>
            </v-img>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text>
              <v-progress-circular
                :rotate="-90"
                :size="50"
                :width="7"
                :value="componentsFree / componentsTotal * 100"
                color="teal"
              >
                {{ componentsFree }}
              </v-progress-circular>
              Free components
            </v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card link>
            <v-img
              :src="imgs[2]"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="100px"
            >
              <v-card-title>Keyboards</v-card-title>
            </v-img>
            <v-card-subtitle></v-card-subtitle>
            <v-card-text></v-card-text>
            <v-card-actions></v-card-actions>
        </v-card>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="6">
        <v-card link>
            <v-img
              :src="imgs[3]"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="100px"
            >
              <v-card-title>Custom Orders</v-card-title>
            </v-img>
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
  
  props: [
    'componentsFree',
    'componentsTotal',
  ],
  
  data: () => ({
    'imgs': [],
  }),

  mounted() {

    axios.get('https://api.unsplash.com/search/photos',{
      headers: {
        Authorization: 'Client-ID Client-ID 3LkI5pmvOcEs72PtTZFbsnoX_n2jDpBDa0JOXh4OJbU'
      },
      params: {
        query: "mechanical keyboard",
      }
    }).then( response=>{
      for( let x = 1; x <= 4; x++ ){
        this.imgs.push( response.data.results[x].urls.full )
      }
      // console.log( response )
    })

  },

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