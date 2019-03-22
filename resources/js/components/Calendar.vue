<template>
  <div>
    <v-progress-circular indeterminate :size="50" :width="5" color="white" v-if="loading"></v-progress-circular>

    <notifications group="notificacion" position="bottom center" />
    <vue-scheduler
      :events="events"
      :event-dialog-config="dialogConfig"
      :event-display="eventDisplay"
      @event-clicked="eventClicked"
      @event-created="eventCreated"
      @month-changed="monthChanged"
    />
    <EventDialog
      v-model="showEventDialog"
      :event="eventSelected"
      @borrarEvento="eventoBorradoDialog"
    />
  </div>
</template>
<script>
import EventDialog from "./EventDialog";
import moment from "moment";
export default {
  data() {
    return {
      showEventDialog: false,
      eventSelected: null,
      ambiente_id: null,
      usuario: null,
      mes: null,
      loading: false,
      events: [],
      dialogConfig: {
        fields: [
          {
            name: "name",
            label: "Motivo Reserva",
            required: true
          },
          {
            name: "user",
            label: "Usuario",
            value: "",
            required: true,
            readonly: true
          }
        ]
      }
    };
  },
  created: function() {
    this.ambiente_id = localStorage.ambiente_id;
    this.usuario = User.nameUser();
    this.dialogConfig.fields[1].value = this.usuario.name;
    let hoy = new Date();
    this.mes = hoy.getMonth() + 1;
    this.cargarEventos(this.mes);
  },
  methods: {
    eventDisplay(event) {
      return (
        event.startTime.format("HH:mm") +
        "-" +
        event.endTime.format("HH:mm") +
        " " +
        event.name
      );
    },
    eventClicked(event) {
      this.eventSelected = event;
      this.showEventDialog = true;
      //this.events = [];
    },
    monthChanged(newDate) {
      this.mes = newDate.getMonth() + 1;
      this.cargarEventos(this.mes);
    },
    eventCreated(event) {
     
      let data = {
        fecha: moment(event.date).format("YYYY-MM-DD"),
        hora_inicio: event.startTime,
        hora_fin: event.endTime,
        motivo: event.name,
        ambiente_id: this.ambiente_id,
        user_id: this.usuario.id
      };
      if (this.fechaPasado(event.date)) {
          this.$notify({
            group: "notificacion",
            title: "Reseva invalida",
            text: "No se puede realizar reservaciones <br> de una fecha pasada",
            type: "error"
          });
          this.cargarEventos(this.mes);
      } else {

      this.$notify({
        group: "notificacion",
        title: "Espere un momento",
        text: "Se esta reservando el ambiente ....",
        type: "warn",
        duration: 5000
      });
        axios({
          method: "post",
          url: "/api/reserva",
          data: data,
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
          }
        })
          .then(res => {
                this.cargarEventos(this.mes);
              if(res.status == 202){
              this.$notify({
                group: "notificacion",
                title: "Reservacion Invalida",
                text: "El ambinete ya se encuentra <br>reservado en ese horario",
                type: "warn",
                duration: 10000
              });
            }else{
              this.$notify({
                group: "notificacion",
                title: "Ambiente Reservado",
                text: "Se reservo el ambiente exitosamente",
                type: "success",
                duration: 5000,
              });
            }
          })
          .catch(error => {
            console.log(error);
            this.cargarEventos(this.mes);
            this.$notify({
              group: "notificacion",
              title: "Error al reservar ambiente",
              text: "Ocurrio un error al reservar el ambiente",
              type: "error"
            });
          });
      }
    },
    cargarEventos(mes) {
      ///reserva/{id_ambiente}/ambiente/{$mes}/mes
      this.loading = true;
      //console.log('Usuario logeado',User.nameUser().id)
      axios
        .request({
          url: `/api/reserva/${this.ambiente_id}/ambiente/${mes}/mes`,
          method: "get",
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`
          }
        })
        .then(res => {
          this.loading = false;
          let events = res.data.data;
          this.events = events.map(function(object) {
            object.estilo =
              object.user_id == User.nameUser().id
                ? "v-cal-event-item-user"
                : "v-cal-event-item";
            return object;
          });

          //this.events = res.data.data;
        })
        .catch(error => {
          this.loading = false;
          console.log(error);
          User.logout();
          this.$bus.$emit("logged", "User logged");
          this.$router.push({ path: "lista-ambientes" });
        });
    },
    eventoBorradoDialog(value) {
      if (value) {
        this.$notify({
          group: "notificacion",
          title: "Reserva Eliminada",
          text: "La reserva se borro exitosamente",
          type: "success",
          duration: 5000,
        });
      } else {
        this.$notify({
          group: "notificacion",
          title: "Reserva sin eliminar",
          text: "No se pudo eliminar la reserva",
          type: "error"

        });
      }
      this.cargarEventos(this.mes);
    },
    fechaPasado(fecha) {
      let hoy = new Date();
      hoy.setHours(0, 0, 0, 0);
      return fecha < hoy;
    }
  },
  components: {
    EventDialog
  }
};
</script>
<style lang="sass" scoped>
  .v-progress-circular
    margin: 0rem
    position: fixed
    left: 50%
    top: 2%
.notifications
  font-size: 14px !important

</style>