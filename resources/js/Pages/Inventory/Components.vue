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
                    Add
                </v-btn>
                <v-btn color="success" text>
                    Stock
                </v-btn>
                <v-btn color="red" text>
                    Delete
                </v-btn>
            </v-toolbar-items>
            <v-spacer></v-spacer>
            <v-select single-line hide-details></v-select>
            <v-text-field hide-details single-line label="Search" v-model="table.search"></v-text-field>
        </v-toolbar>
        <v-data-table
            :headers="table.headers"
            :items="components"
            :search="table.search"
            class="mt-12"
            show-select
        >
            <template v-slot:item.name="{item}">
                <v-tooltip v-if="!!item.img_url" bottom
                >
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">{{item.name}} <v-icon small>mdi-camera</v-icon></span>
                  </template>
                  Click to see photo
                </v-tooltip>
                <span v-else>{{item.name}}</span>
            </template>
            <template v-slot:header.data-table-select>
                <v-checkbox v-model="tableSelectAll"></v-checkbox>
            </template>
            <template v-slot:item.data-table-select="{ item }">
                <!-- <td> -->
                    <v-checkbox
                    v-model="table.selected"
                    :value="item.id"
                    ></v-checkbox>
                <!-- </td> -->
            </template>
            <template v-slot:item.keyboard_component_type_id="{ item }">
                {{ getLayout(item.keyboard_component_type_id) }}
            </template>
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

    computed: {
        tableSelectAll: {
            get: function(){
                return this.table.selected == this.components.map( c => c.id )
            },
            set: function( v ){
                if( !v ){
                    this.table.selected = []
                }
                else{
                    this.table.selected = this.components.map( c => c.id )
                }
            }
        },
    },

    data(){
        return{
            
            
            table: {
                selected: [ ],
                search: '',
                headers: [
                    // {
                    //     text: 'ID',
                    //     value: 'id',
                    // },
                    {
                        text: 'Name',
                        value: 'name',
                    },
                    {
                        text: 'Type',
                        value: 'keyboard_component_type_id'
                    },
                    {
                        text: 'Price',
                        value: 'price'
                    },
                    {
                        text: 'Stock',
                        value: 'stock'
                    },
                    {
                        text: 'Status',
                        value: 'status'
                    },
                ],
            },
            componentAdd: false,
        }
    },

    layout: (h, page) => {
        return h( Layout, [
            h( InventoryLayout, [page] )
        ])
    },

    watch:{
        table(){
            console.log("CHANGED TABLE");
        }
    },

    methods: {
        showAdd(){
            // this.components = {},
            this.componentAdd = true;
        },
        getLayout( id ){
            return this.comp_types.find( x => x.id == id ).name
        }
    },

}
</script>