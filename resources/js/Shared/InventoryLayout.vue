<template>
<v-container fill-height ma-0 class="align-start">
<v-row fill-height>
    <v-col cols="2" fill-height>
    <v-navigation-drawer permanent>
      <v-list-item link @click="inertiaVisit('/inventory')">
        <v-list-item-content>
          <v-list-item-title class="title">
            Inventory
          </v-list-item-title>
          <v-list-item-subtitle>
            Notifications!
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list nav>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
          @click="inertiaVisit(item.link)"
        >
          <v-list-item-content >
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    </v-col>
    
    <v-col cols = "10">
        <slot/>
    </v-col>
</v-row>
    <v-footer absolute>
        HEllo
    </v-footer>
</v-container>
</template>

<script>

import {Inertia} from '@inertiajs/inertia'

export default {

  data () {
    return {
        items: [
            { title: 'Components', link: '/inventory/components', },
            { title: 'Keyboards', link: '/inventory/keyboards', },
            { title: 'Prebuilt Orders', link: '/inventory/prebuilt_orders', },
            { title: 'Custom Orders', link: '/inventory/custom_orders', },
        ],
        right: null
    }
  },

  methods: {
    inertiaVisit: function ( link ){
        console.log( link );
        Inertia.visit(link);
    }
  }

}

</script>