<template>
<layout>
  <v-btn color="primary">Hello world!</v-btn>
</layout>
</template>

<script>
import Layout from './../../Shared/Layout'

export default {

    components:{
        Layout,
    },

    mounted(){
        console.log("COMPONENT MOUNTED")
    }
    
}
</script>