<template>
<v-container fluid grid-list-xl>
    <v-layout row justify-center>
      
      <v-flex xs12 md4 >
        <v-card >
          <v-card-text>
              <h3 class="headline mb-0 text-md-center">Ingrese sus credenciales</h3>
              <v-alert
              :value="true"
              type="warning"
              v-if="error_login"
            >
              Usuario o Password equivocado.
            </v-alert>
              <v-form  @submit.prevent="login">
                <v-text-field
                v-model="form.email"
                label="Ingrese su correo electronico"
                required
                :error-messages="emailErrors"
                @input="$v.form.email.$touch()"
                @blur="$v.form.email.$touch()"
                ></v-text-field>
                <v-text-field
                v-model="form.password"
                :append-icon="showPassword ? 'visibility' : 'visibility_off'"
                :type="showPassword ? 'text' : 'password'"
                label="Ingrese su password"
                counter
                @click:append="showPassword = !showPassword"
                required
                :error-messages="passwordErrors"
                @input="$v.form.password.$touch()"
                @blur="$v.form.password.$touch()"
                ></v-text-field>

                <div class="text-md-center">
                <v-btn type="submit" color="primary">Ingresar</v-btn>
                <v-btn >Limpiar</v-btn>
                </div>

            </v-form >
          </v-card-text>
        </v-card>
      </v-flex>
      <!-- <v-flex xs12 md2>
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
      </v-flex> -->
      
    </v-layout>
</v-container>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { required, maxLength, email } from 'vuelidate/lib/validators'
export default {
    mixins: [validationMixin],

    validations: {
      form: {
        email: { required, email },
        password: { required }
      }
    },
    data () {
      return {
        error_login: false,
        showPassword: false,
        form: {
            email: null,
            password: null
        }
      }
    },
    computed: {
      emailErrors () {
        const errors = []
        if (!this.$v.form.email.$dirty) return errors
        !this.$v.form.email.email && errors.push('Debe ser un email valido')
        !this.$v.form.email.required && errors.push('Email es requerido')
        return errors
      },
      passwordErrors () {
        const errors = []
        if (!this.$v.form.password.$dirty) return errors
        !this.$v.form.password.required && errors.push('Password es requerido.')
        return errors
      },
    },
    methods:{
        login(){
          this.$v.form.$touch();
          if(this.$v.form.$error) return
          axios.post('/api/auth/login',this.form)
          .then(res => {
              User.resposeAfterLogin(res)
              this.$router.push({ path: 'lista-ambientes' })
              window.location.reload()
          })
          .catch(error=> {
              console.log(error.response)
              this.error_login = true
          })
        }
    }
}
</script>

<style>

</style>
