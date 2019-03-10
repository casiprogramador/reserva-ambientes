<template>
<v-dialog v-model="show" max-width="300px">
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
                    <p>{{ event.startTime}}</p>
                 </v-flex>
                 <v-flex md6>
                    <p><b>Hora Fin:</b></p>
                 </v-flex>
                 <v-flex md6>
                     <p>{{ event.endTime}}</p>
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
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            flat
             @click.stop="show=false"
          >
            Cerrar
          </v-btn>
        </v-card-actions>
  </v-card>
</v-dialog>
</template>
<script>
export default {
  props: {
     value: Boolean,
     event
  },
  computed: {
    show: {
      get () {
        //console.log('Evento',this.event);
        return this.value
      },
      set (value) {
         this.$emit('input', value)
      }
    }
  }
}
</script>