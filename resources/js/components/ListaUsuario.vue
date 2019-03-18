<template>
  <div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Usuarios Registrados</v-toolbar-title>
      <v-spacer></v-spacer>
<!-- Inicio Dialog -->
<v-dialog v-model="dialog" max-width="500px">
        <v-card>
          <v-card-title>
            <span class="headline">Editar Usuario</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm12 md12>
                  <v-text-field
                  v-model="editedItem.name"
                  label="Nombre"
                  required
                ></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12>
                  <v-text-field
                  v-model="editedItem.email"
                  label="Email"
                  required
                  ></v-text-field>
                </v-flex>
                
                
                <v-flex xs12 sm12 md12>
                    <v-select
                  item-text="label"
                  item-value="value"
                  v-model="editedItem.rol"
                  :items="roles"
                  label="Rol"
                  ></v-select>

                </v-flex>
                <v-flex xs12 sm12 md12>
                <v-checkbox
                  v-model="editedItem.habilitado"
                  label="Habilitado"
                  required
                ></v-checkbox>
                </v-flex>
                <v-spacer></v-spacer>
                <v-flex xs12 sm12 md12>
                <v-checkbox
                  v-model="editedItem.password_enabled"
                  @click="cambiarEstadoPassword()"
                  label="Cambiar Password"
                ></v-checkbox>
                </v-flex>
                <v-flex xs12 sm12 md12 v-if="password_enable">
                  <v-text-field
                  v-model="editedItem.password"
                  label="Password"
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="dialog=false">Cancelar</v-btn>
            <v-btn color="blue darken-1" flat @click="actualizar">Actualizar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
<!-- Fin Dialog -->
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
      password_enable: false,
      headers: [
        { text: 'ID',value: 'id'},
        { text: 'Nombre', value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'Rol', value: 'rol' },
        { text: 'Estado', value: 'habilitado' },
        { text: 'Ultima Actualizacion', value: 'created_at' },
        { text: 'Opciones', value: 'name', sortable: false }
      ],
      roles: [
            {
                label: 'Usuario',
                value: 'usuario'
            },
            {
                label: 'Administrador',
                value: 'administrador'
            }
        ],
      editedItem: {
        name: '',
        email: '',
        password: '',
        email: ''
      },  
      usuarios: [],
    }),

    created () {
      this.initialize()
      this.$bus.$emit('cambiarTextoTitulo', 'Lista de Usuarios')
      this.editedItem.password_enabled = false
    },

    methods: {
      initialize () {
          axios.get('/api/usuario')
            .then((res) => {
              this.usuarios = res.data.data;
              console.log('respuesta',res.data.data)
            })
            .catch((error) => {
              User.logout()
              this.$bus.$emit('logged', 'User logged')
              this.$router.push({ path: 'lista-ambientes' })
            })
      },
      editItem (item) {
        this.editedItem = item
        this.editedItem.password_enabled = false
        this.dialog = true
      },
      registrarUsuario(){
          this.$router.push({ path: 'registrar-usuario' }) 
      },
      actualizar(){

        console.log(this.editedItem)
        axios.put(`/api/usuario/${this.editedItem.id}`,this.editedItem)
            .then((res) => {
              //User.resposeAfterLogin(res)
              this.initialize()
              this.dialog = false
            })
            .catch((error) => {
              this.errors = error.response.data.errors
            })
      },
      cambiarEstadoPassword(){
        this.password_enable = this.editedItem.password_enabled
      }
    }
  }
</script>