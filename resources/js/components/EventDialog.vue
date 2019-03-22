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
             @click.stop="borrarEvento(event)"
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
     event: Object,
  },
  methods: {
    borrarEvento(event){
      if(this.fechaPasado(event.date)){
          this.show=false
          this.$emit('borrarEvento', false)
      }else{
        axios
        .request({
          url: `/api/reserva/${event.id}`,
          method: "delete",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
          }
        })
        .then((res) => {
            this.show=false
            this.$emit('borrarEvento', true)
        })
          .catch((error) => {
            this.$emit('borrarEvento', false)
        })  
      }

    },
    cerrarDialog(){
      this.show=false
    },
    fechaPasado(fecha){
      let hoy = new Date();
      hoy.setHours(0,0,0,0);  
      return fecha < hoy
    }
  },
  computed: {
    show: {
      get () {
        this.usuario = User.nameUser();
        return this.value
      },
      set (value) {
         this.$emit('input', value)
      }
    }
  }
}
</script>