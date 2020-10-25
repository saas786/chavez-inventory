<template>
    <v-card>
        <v-card-text>Hello world!</v-card-text>
    </v-card>
</template>

<script>
import LayoutVue from '../../Shared/Layout.vue'
export default {

    layout: (h, page) => {
        return h( Layout, [
            h( ShopLayout, [page] )
        ])
    },

    data: {
        username: '',
        password: '',
    }
}
</script>