<template>
<v-dialog
  v-model="componentAdd"
  persistent
>
  <v-card>
    <v-card-title>Add Component</v-card-title>
    <v-form ref="form" v-model="valid" @submit.prevent="addComponent">
    <v-card-text>
        <v-row>
          <v-col>
            <v-text-field v-model="form.name" :rules="rules.name" label="Name" required></v-text-field>
          </v-col>
          <v-col>
            <v-select :items="component_type_options" :rules="rules.keyboard_component_type_id" label="Type" v-model="form.keyboard_component_type_id"></v-select>
            <!-- {{ form.keyboard_component_type_id }} -->
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-select :items="layout_options" label="Layout" :rules="rules.layout_id" v-model="form.layout_id"></v-select>
            <!-- {{ form.layout_id }} -->
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-file-input
              label="Image"
              show-size
              counter
              v-model="form.image"
              accept="image"
            >
            </v-file-input>
            <div v-if="laravelErrorBag('image', 'components')">
              <span color="red">{{ laravelErrorBag('image', 'components') }}</span>
            </div>
          </v-col>
          <v-col>
            <v-text-field type="number" step="0.01" label="Price" :rules="rules.price" v-model="form.price"></v-text-field>
          </v-col>
          <v-col>
            <v-text-field type="number" step="1" label="Stock" v-model="form.stock" :rules="rules.stock"></v-text-field>
            <!-- {{ form.stock }} -->
        
          </v-col>
        </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn outlined color="red" @click="close">Cancel</v-btn>
      <v-btn :disabled="!valid" type="submit" color="success">Add</v-btn>
    </v-card-actions>
    </v-form>
  </v-card>
</v-dialog>
</template>

<script>

import { Inertia } from '@inertiajs/inertia'

export default {
  
  props: [
    'comp_types',
    'layouts',
    'componentAdd',
  ],

  computed: {
    component_type_options(){
      return this.comp_types.map( ( comp ) => { return { value: comp.id, text: comp.name }} )
    },
    layout_options(){
      return this.layouts.map( layout => {return { value: layout.id, text: layout.name }})
    },
  },

  data(){
    return {
      valid: true,
      form: {
        name: '',
        keyboard_component_type_id: 0,
        layout_id: 0,
        stock: '',
        price: '',
        image: [],
      },
      rules: {
        name: [ 
          v => !!v || 'Name is required',
          v => ( v && v.length <= 255 ) || 'Name must be less than 255 characters.',
        ],
        keyboard_component_type_id: [
          v => !!v || 'Type is required',
          v => ( v && v < 6 && v > 0 ) || 'Select a valid type.',
        ],
        layout_id: [
          v => !!v || 'Layout is required',
          v => ( v && v < 7 && v > 0 ) || 'Select a valid layout.',
        ],
        stock: [
          v => ( Number.isInteger(Number(v)) && v >= 0 ) || 'Stock must be a positive whole number.'
        ],
        price: [
          v => ( Number(v) >= 0 ) || 'Price must not be negative.'
        ],
      },
    }
  },

  methods: {
    close(){
      this.$refs.form.reset()
      this.$parent.componentAdd = false
    },
    resetValidation(){
      this.$refs.form.resetValidation()
    },
    addComponent(){

      let data = new FormData()

      data.append('name', this.form.name);
      data.append('keyboard_component_type_id', this.form.keyboard_component_type_id);
      data.append('layout_id', this.form.layout_id);
      data.append('stock', this.form.stock);
      data.append('price', this.form.price);
      data.append('image', this.form.image);

      // console.log( data );

      Inertia.post( '/inventory/components', data )
    }
  }

}
</script>