<template>
     <v-card>
      <v-container
        fluid
        grid-list-lg
      >
        <v-layout row wrap>
          <v-flex xs12 md3 v-for="ambiente in listaAmbientes" :key="ambiente.id">
            <v-card :color="ambiente.color" class="white--text" >
              <v-card-title primary-title>
                <div>
                  <div class="headline">{{ ambiente.nombre }}</div>
                  <span>{{ ambiente.direccion }}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn @click="verReserva(ambiente)" flat dark>Ver Reservas</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>

        </v-layout>
      </v-container>
      <v-card-text>
            <v-btn
              absolute
              dark
              fab
              bottom
              right
              color="pink"
              @click="nuevoAmbiente()"
            >
              <v-icon>add</v-icon>
            </v-btn>
          </v-card-text>
      
    </v-card>
</template>

<script>
export default {
  data: function () {
    return {
      listaAmbientes: null
    }
  },
  created: function () {
       this.obtenerAmbientes();
  },
  methods:{
        obtenerAmbientes(){
            axios.get('/api/ambiente')
            .then((res) => {
              this.listaAmbientes = res.data.data;
              console.log(res.data.data)
            })
            .catch((error) => {
              this.errors = error.response.data.errors
            })
            
        },
        verReserva(ambiente){
          localStorage.ambiente_id = ambiente.id
          this.$router.push({ path: 'reserva' })  
        },
        nuevoAmbiente(){
          this.$router.push({ path: 'registrar-ambiente' })  
        }
    }
}
</script>

<style>

</style>
