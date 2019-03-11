<template>
  <v-toolbar dark color="primary">
    <v-menu class="hidden-md-and-up">
          <v-toolbar-side-icon slot="activator"></v-toolbar-side-icon>
          <v-list two-line>
            <router-link to="/lista-usuarios" v-if="menu.listaUsuario">
            <v-list-tile avatar>
              <v-list-tile-content>
                <v-list-tile-title>Usuarios</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
           </router-link>
            <router-link to="/lista-ambientes" v-if="menu.listaAmbientes">
            <v-list-tile avatar>
              <v-list-tile-content>
                <v-list-tile-title>Ambientes</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            </router-link>
             <router-link to="/login" v-if="menu.ingresar">
            <v-list-tile avatar>
              <v-list-tile-content>
                <v-list-tile-title>Ingresar</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
            </router-link>
            <v-list-tile avatar v-if="menu.salir" @click="salir()">
              <v-list-tile-content>
                <v-list-tile-title>Salir</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
        </v-list>
    </v-menu>

    <v-toolbar-title>Reserva de ambiente</v-toolbar-title>
    <v-spacer></v-spacer>
    <div class="hidden-sm-and-down">
      <router-link to="/lista-usuarios" v-if="menu.listaUsuario">
      <v-btn flat>Usuarios</v-btn>
      </router-link>
      <router-link to="/lista-ambientes" v-if="menu.listaAmbientes">
        <v-btn flat>Ambientes</v-btn>
      </router-link>
      <router-link to="/login" v-if="menu.ingresar">
        <v-btn flat>Ingresar</v-btn>
      </router-link>
      <v-btn flat v-if="menu.salir" @click="salir()">Salir</v-btn>
    </div>
  </v-toolbar>
</template>
<script>
  export default {
    data: () => ({
      usuario: null,
      menu: {
        listaUsuario: false,
        listaAmbientes: true,
        ingresar: true,
        salir:false

      }
    }),

      created () {
        this.usuario = User.nameUser();
        if(this.usuario){
          if(this.usuario.rol === 'administrador'){
            this.menu.listaUsuario = true
            this.menu.listaAmbientes = true
            this.menu.ingresar = false
            this.menu.salir = true
          }else{
            this.menu.listaUsuario = false
            this.menu.listaAmbientes = true
            this.menu.ingresar = false
            this.menu.salir = true
          }
          
        }
        console.log('usuario',this.usuario)
        //this.initialize()
      },
      methods: {
        salir(){
          User.logout()
        }
      }
    }
</script>