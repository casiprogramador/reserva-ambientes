<template>
   <div>
     <toolbar></toolbar>
      <router-view></router-view>
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