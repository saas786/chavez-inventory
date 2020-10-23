<template>
  <v-btn color="primary" block>Landing Page!</v-btn>
</template>

<script>
import Layout from './../../Shared/Layout'
import ShopLayout from './../../Shared/ShopLayout'

export default {

    layout: (h, page) => {
        return h( Layout, [
            h( ShopLayout, [page] )
        ])
    },

    mounted(){
        
    }
    
}
</script>