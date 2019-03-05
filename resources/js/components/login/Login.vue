<template>
<v-container fluid grid-list-xl>
    <v-layout row justify-center>
      
      <v-flex xs12 md3>
        <v-card >
          <v-card-text>
              <h3 class="headline mb-0 text-md-center">Ingrese sus credenciales</h3>
              <v-form  @submit.prevent="login">
                <v-text-field
                v-model="form.email"
                label="Ingrese su correo electronico"
                required
                ></v-text-field>
                <v-text-field
                v-model="form.password"
                :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                :type="showPassword ? 'text' : 'password'"
                label="Ingrese su password"
                counter
                @click:append="showPassword = !showPassword"
                ></v-text-field>

                <div class="text-md-center">
                <v-btn type="submit" color="primary">Ingresar</v-btn>
                <v-btn >Limpiar</v-btn>
                </div>

            </v-form >
          </v-card-text>
        </v-card>
      </v-flex>
      <v-flex xs12 md2>
        <v-card  class="mx-auto" color="#26c6da">
          <v-card-text class="white--text">
              <v-icon color="white">info</v-icon>
              Si usted requiere acceso a la aplicacion:
              <ul>
                  <li>Envie un correo a mchoque@coboser.com con su NOMBRE, EMAIL y Numero de Carnet de Identidad <br> solicitando el acceso</li>
                  <li>O llame al 2459812 interno 327</li>
              </ul>
                
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
        showPassword: false,
        form: {
            email: null,
            password: null
        }
      }
    },
    methods:{
        login(){
            console.log("Login");
            axios.post('/api/auth/login',this.form)
            .then(res => console.log(res.data))
            .catch(error=> console.log(error.response.data))
        }
    }
}
</script>

<style>

</style>
