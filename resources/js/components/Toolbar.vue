<template>
  <v-toolbar dark color="primary">
    <v-toolbar-side-icon></v-toolbar-side-icon>
    <v-toolbar-title>Reserva de ambiente</v-toolbar-title>
    <v-spacer></v-spacer>
    <div class="hidden-sm-and-down">
      <router-link to="/lista-usuarios">
      <v-btn flat>Usuarios</v-btn>
      </router-link>
      <router-link to="/lista-ambientes">
        <v-btn flat>Ambientes</v-btn>
      </router-link>
      <router-link to="/login">
        <v-btn flat>Ingresar</v-btn>
      </router-link>
      <v-btn flat>Salir</v-btn>
    </div>
  </v-toolbar>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>