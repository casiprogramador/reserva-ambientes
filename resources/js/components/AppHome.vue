<template>
   <div>
     <toolbar></toolbar>
      <router-view></router-view>
      <v-footer
    height="32px"
    color="primary lighten-1"
    absolute
  >
    <v-layout
      justify-center
      row
      wrap
      
    >
      <v-flex
        py-3
        text-xs-center
        grey lighten-5
        xs12
      >
        Sudamericana Seguros SRL
      </v-flex>
    </v-layout>
  </v-footer>
   </div>
</template>
<script>
import toolbar from './Toolbar';
    export default {
        components:{
          toolbar
        },
        mounted() {
            console.log('Component Home.')
        }
    }
</script>