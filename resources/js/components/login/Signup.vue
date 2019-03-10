<template>
<v-container fluid grid-list-xl>
    <v-layout row justify-center>
      
      <v-flex xs12 md3>
        <v-card >
          <v-card-text>
              <h3 class="headline mb-0 text-md-center">Registro de Usuario</h3>
              <v-form  @submit.prevent="signup">
                 <v-text-field
                v-model="form.name"
                label="Nombre"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.name">{{errors.name[0]}}</span>
                <v-text-field
                v-model="form.email"
                label="Email"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.email">{{errors.email[0]}}</span>
                <v-text-field
                v-model="form.password"
                label="Password"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.password">{{errors.password[0]}}</span>
                <v-select
                item-text="label"
                item-value="value"
                v-model="form.rol"
                :items="roles"
                label="Rol"
                ></v-select>
                <span class="red--text" v-if="errors.rol">{{errors.rol[0]}}</span>
                <div class="text-md-center">
                <v-btn type="submit" color="primary">Ingresar</v-btn>
                </div>

            </v-form >
          </v-card-text>
        </v-card>
      </v-flex>
     
    </v-layout>
</v-container>
</template>

<script>
export default {
    data () {
      return {
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
        form: {
            name: null,
            email: null,
            password: null,
            rol: null
        },
        errors:{}
      }
    },
    methods:{
        signup(){
            console.log(this.form);
            //User.signup(this.form);
            axios.post('/api/auth/signup',this.form)
            .then((res) => {
              //User.resposeAfterLogin(res)
              this.$router.push({ path: 'lista-usuarios' })  
            })
            .catch((error) => {
              this.errors = error.response.data.errors
            })
            
        }
    }
}
</script>

<style>

</style>