<template>
    <div>

              <v-progress-circular
                  indeterminate
                  :size="50"
                  :width="5"
                  color="white"
                  v-if="loading"
                ></v-progress-circular>

      
      <notifications group="notificacion" position="bottom center" />
        <vue-scheduler 
        :events="events" 
        :event-dialog-config="dialogConfig" 
        :event-display="eventDisplay"
        @event-clicked="eventClicked"
        @event-created="eventCreated"
        @month-changed="monthChanged"/>
        <EventDialog v-model="showEventDialog" :event="eventSelected" @borrarEvento="eventoBorradoDialog"/>
    </div>
</template>
<script>
import EventDialog from './EventDialog'
import moment from 'moment';
  export default {
    data() {
      return {
          showEventDialog: false,
          eventSelected: null,
          ambiente_id:null,
          usuario:null,
          mes:null,
          loading: false,
          events: [],
        dialogConfig: {
          fields: [
              {
                  name: 'name',
                  label: 'Motivo Reserva',
                  required: true
              },
              {
                  name: 'user',
                  label: 'Usuario',
                  value: '',
                  required: true,
                  readonly: true
              }
          ]
        }
      }
    },
    created: function () {
      this.ambiente_id = localStorage.ambiente_id;
      this.usuario = User.nameUser();
      this.dialogConfig.fields[1].value = this.usuario.name
      let hoy = new Date()
      this.mes = hoy.getMonth()+1;
      this.cargarEventos(this.mes)
      
    },
    methods: {
      eventDisplay(event) {
        return event.startTime.format('HH:mm')+'-'+event.endTime.format('HH:mm')+' '+event.name
      },
      eventClicked(event) {
            this.eventSelected = event;
            this.showEventDialog = true 
            //this.events = [];
      },
      monthChanged(newDate) {
            //console.log('Month Changed');
            //console.log(newDate.getMonth()+1);
            this.mes = newDate.getMonth()+1;
            this.cargarEventos(this.mes)
      },
      eventCreated(event) {
            let data = {
              fecha: moment(event.date).format('YYYY-MM-DD'),
              hora_inicio: event.startTime,
              hora_fin: event.endTime,
              motivo: event.name,
              ambiente_id: this.ambiente_id,
              user_id: this.usuario.id
            }
            axios.post('/api/reserva',data)
            .then((res) => {
               console.log('Respuesta Evento Creado',res);
               this.cargarEventos(this.mes)
                this.$notify({
                  group: 'notificacion',
                  title: 'Ambiente Reservado',
                  text: 'Se reservo el ambiente',
                  type: 'success',
                });
            })
            .catch((error) => {
              //this.errors = error.response.data.errors
              console.log(error)
              this.cargarEventos(this.mes)
              this.$notify({
                  group: 'notificacion',
                  title: 'Error al reservar ambiente',
                  text: 'Ocurrio un error al reservar el ambiente',
                  type: 'error',
                });
            })
            console.log('Event created');
      },
      cargarEventos(mes){
        ///reserva/{id_ambiente}/ambiente/{$mes}/mes
        this.loading = true
        axios.get(`/api/reserva/${this.ambiente_id}/ambiente/${mes}/mes`)
            .then((res) => {
               this.loading = false
               this.events = res.data.data;
            })
            .catch((error) => {
              this.loading = false
              console.log(error)
            }) 
      },
      eventoBorradoDialog(value){
        if(value){
          this.$notify({
                  group: 'notificacion',
                  title: 'Reserva Borrada',
                  text: 'La reserva se borro exitosamente',
                  type: 'success',
                });
        }else{
          this.$notify({
                  group: 'notificacion',
                  title: 'Error',
                  text: 'Ocurrio un error al intentar borrar la reserva',
                  type: 'error',
                });
        }
        this.cargarEventos(this.mes)
      }
    },
    components: {
        EventDialog
    }
  }
</script>
<style lang="sass" scoped>
  .v-progress-circular
    margin: 0rem
    position: fixed
    left: 50%
    top: 2%
</style>