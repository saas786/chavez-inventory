<template>
    <v-container class="overflow-hidden">
        <component-create
          :comp_types="comp_types"
          :layouts="layouts"
          :componentAdd="componentAdd"
        />
        <v-toolbar
        >
            <v-toolbar-title class="mr-8">Controls</v-toolbar-title>
            <v-toolbar-items>
                <v-btn
                  color="primary"
                  text
                  @click="showAdd"
                >
                    Add Component
                </v-btn>
                <v-btn color="success" text>
                    Add Stock
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-data-table
            :headers="headers"
            :items="components"
            :items-per-page="15"
            class="mt-12"
            show-select
        >

        </v-data-table>
    </v-container>
</template>

<script>

import InventoryLayout from './../../Shared/InventoryLayout'
import Layout from './../../Shared/Layout'
import ComponentCreate from './../../components/ComponentCreate'


export default {
    
    components: {
        ComponentCreate,
    },
    
    props: [
        'components',
        'comp_types',
        'layouts',
    ],

    data(){
        return{
            headers: [
                {
                    text: 'ID',
                    value: 'id',
                },
                {
                    text: 'Name',
                    value: 'name',
                },
                {
                    text: 'Type',
                    value: 'keyboard_component_type_id'
                },
                {
                    text: 'Status',
                    value: 'status'
                },
            ],
            componentAdd: false,
        }
    },

    layout: (h, page) => {
        return h( Layout, [
            h( InventoryLayout, [page] )
        ])
    },

    methods: {
        showAdd(){
            // this.components = {},
            this.componentAdd = true;
        }
    },

}
</script>