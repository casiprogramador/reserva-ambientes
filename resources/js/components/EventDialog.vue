<template>
<v-dialog v-model="show" max-width="400px">
  <v-card v-if="event">
      <v-card-title
          class="headline deep-purple white--text"
          primary-title>
          {{ event.name}}
        </v-card-title>

        <v-card-text>
            <v-container grid-list-md text-xs-left>
              <v-layout row wrap>
                 <v-flex md6>
                    <p><b>Usuario:</b></p>
                 </v-flex>
                 <v-flex md6>
                     <p>{{ event.user}}</p>
                 </v-flex>
                 <v-flex md6>
                    <p><b>Hora Inicio:</b> </p>
                 </v-flex>
                 <v-flex md6>
                    <p>{{ moment(event.startTime, "HH:mm:ss").format("hh:mm A") }}</p>
                 </v-flex>
                 <v-flex md6>
                    <p><b>Hora Fin:</b></p>
                 </v-flex>
                 <v-flex md6>
                     <p>{{ moment(event.endTime, "HH:mm:ss").format("hh:mm A") }}</p>
                 </v-flex>
                  <v-flex md6>
                    <p><b>Fecha:</b></p>
                 </v-flex>
                 <v-flex md6>
                     <p>{{ event.date.getDate()}}/{{this.event.date.getMonth()}}/{{this.event.date.getFullYear()}}</p>
                 </v-flex>
              </v-layout>
            </v-container>
          
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn
            color="error"
            flat
            v-if="event.user_id==usuario.id"
             @click.stop="borrarEvento(event.id)"
          >
            Borrar Evento
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
             @click.stop="cerrarDialog()"
          >
            Cerrar
          </v-btn>
        </v-card-actions>
  </v-card>
</v-dialog>
</template>
<script>
import moment from 'moment';
export default {
data() {
      return {
          usuario:null
      }
},
  props: {
     value: Boolean,
     event
  },
  methods: {
    borrarEvento($id_evento){
      axios.delete(`/api/reserva/${$id_evento}`)
            .then((res) => {
               this.show=false
                this.$emit('borrarEvento', true)
            })
            .catch((error) => {
                    this.$emit('borrarEvento', false)
            }) 
    },
    cerrarDialog(){
      this.show=false
    }
  },
  computed: {
    show: {
      get () {
        this.usuario = User.nameUser();
        console.log('Usuario Evento',this.usuario)
        return this.value
      },
      set (value) {
         this.$emit('input', value)
      }
    }
  }
}
</script>