<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Usuarios Registrados</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn color="primary" dark @click="registrarUsuario">
        Nuevo Usuario
      </v-btn>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="usuarios"
      class="elevation-1"
    >
      <template v-slot:items="props">
        <td>{{ props.item.id }}</td>
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.email }}</td>
        <td>{{ props.item.rol.toUpperCase() }}</td>
        <td>
            <div v-if="props.item.habilitado">
                <v-chip color="green" text-color="white">HABILITADO</v-chip>
            </div>
            <div v-else>
                <v-chip color="red" text-color="white">DESHABILITADO</v-chip>
            </div>
        </td>
        <td>{{moment(props.item.created_at).format('DD-MM-YYYY')}}</td>
        <td class="layout px-0">
          <v-icon
            small
            class="mr-2"
            @click="editItem(props.item)"
          >
            edit
          </v-icon>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>
<script>
  export default {
    data: () => ({
      dialog: false,
      headers: [
        { text: 'ID',value: 'id'},
        { text: 'Nombre', value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'Rol', value: 'rol' },
        { text: 'Estado', value: 'habilitado' },
        { text: 'Fecha Creacion', value: 'created_at' },
        { text: 'Opciones', value: 'name', sortable: false }
      ],
      usuarios: [],
    }),

    computed: {
      
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
          axios.get('/api/usuario')
            .then((res) => {
              this.usuarios = res.data.data;
              console.log('respuesta',res.data.data)
            })
            .catch((error) => {
              this.errors = error.response.data.errors
            })
      },
      registrarUsuario(){
          this.$router.push({ path: 'registrar-usuario' }) 
      }
    }
  }
</script>