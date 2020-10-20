<template>
  <v-app>
    <v-app-bar
    app
    dark
    prominent
    shrink-on-scroll
    src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
    >
      <v-toolbar-title>Custom Mech KBD</v-toolbar-title>
      <v-toolbar-items>
          One
      </v-toolbar-items>
    </v-app-bar>
    <v-content>
      <slot/>
    </v-content>
  </v-app>
</template>

<script>
export default {

}
</script>