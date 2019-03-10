<template>
<v-container fluid grid-list-xl>
    <v-layout row justify-center>
      
      <v-flex xs12 md3>
        <v-card >
          <v-card-text>
              <h3 class="headline mb-0 text-md-center">Registro de Ambiente</h3>
              <v-form  @submit.prevent="registrarAmbiente">
                 <v-text-field
                v-model="form.nombre"
                label="Nombre"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.nombre">{{errors.nombre[0]}}</span>
                <v-text-field
                v-model="form.direccion"
                label="Direccion"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.direccion">{{errors.direccion[0]}}</span>
                <v-text-field
                v-model="form.color"
                label="Color"
                required
                ></v-text-field>
                <span class="red--text" v-if="errors.color">{{errors.color[0]}}</span>
                
                <div class="text-md-center">
                <v-btn type="submit" color="primary">Registrar Ambiente</v-btn>
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
        form: {
            nombre: null,
            direccion: null,
            color: null
        },
        errors:{}
      }
    },
    methods:{
        registrarAmbiente(){
            console.log(this.form);
            //User.signup(this.form);
            axios.post('/api/ambiente',this.form)
            .then((res) => {
              this.$router.push({ path: 'lista-ambientes' })  
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