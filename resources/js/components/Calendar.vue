<template>
    <div>
      <notifications group="notificacion" position="bottom center" />
        <vue-scheduler 
        :events="events" 
        :event-dialog-config="dialogConfig" 
        :event-display="eventDisplay"
        @event-clicked="eventClicked"
        @event-created="eventCreated"/>
        <EventDialog v-model="showEventDialog" :event="eventSelected"/>
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
        axios.get(`/api/reserva/${this.ambiente_id}/ambiente`)
            .then((res) => {
               console.log('Reservas',res.data.data);
               this.events = res.data.data;
            })
            .catch((error) => {
              console.log(error)
            }) 
      
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
              this.$notify({
                  group: 'notificacion',
                  title: 'Error al reservar ambiente',
                  text: 'Ocurrio un error al reservar el ambiente',
                  type: 'error',
                });
            })
            console.log('Event created');
      }
    },
    components: {
        EventDialog
    }
  }
</script>