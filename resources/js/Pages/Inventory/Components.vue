<template>
    <v-container>
        <v-data-table
            :headers="headers"
            :items="components"
            :items-per-page="15"
        >

        </v-data-table>
    </v-container>
</template>

<script>

import InventoryLayout from './../../Shared/InventoryLayout'
import Layout from './../../Shared/Layout'

export default {
    
    props: [
        'components',
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
            ]
        }
    },

    layout: (h, page) => {
        return h( Layout, [
            h( InventoryLayout, [page] )
        ])
    },

}
</script>