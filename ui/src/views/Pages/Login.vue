<template>
  <div>
    <!-- Header -->
    <div class="header bg-gradient-success py-3 py-lg-4">
      <b-container>
        <div class="header-body text-center mb-7">
          <b-row class="justify-content-center">
            <b-col xl="5" lg="6" md="8" class="px-5">
              <h1 class="text-white">Bem vido ao SGE</h1>
            </b-col>
          </b-row>
        </div>
      </b-container>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
             xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <b-container class="mt--8 pb-5">
      <b-row class="justify-content-center">
        <b-col lg="5" md="7">
          <b-card no-body class="bg-secondary border-0 mb-0">
            <b-card-body class="px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Entre com suas credenciais</small>
                <span v-if="message" class="badge badge-danger">{{ message }}</span>
              </div>
              <validation-observer v-slot="{handleSubmit}" ref="formValidator">
                <b-form role="form" @submit.prevent="handleSubmit(onSubmit)">
                  <base-input alternative
                              class="mb-3"
                              name="Email"
                              :rules="{required: true, email: true}"
                              prepend-icon="ni ni-email-83"
                              placeholder="Email"
                              v-model="model.email">
                  </base-input>

                  <base-input alternative
                              class="mb-3"
                              name="Senha"
                              :rules="{required: true, min: 3}"
                              prepend-icon="ni ni-lock-circle-open"
                              type="password"
                              placeholder="Senha"
                              v-model="model.password">
                  </base-input>

                  <div class="text-center">
                    <base-button type="primary" native-type="submit" class="my-4">Entrar</base-button>
                  </div>
                </b-form>
              </validation-observer>
            </b-card-body>
          </b-card>
          <b-row class="mt-3">
            <b-col cols="6" class="text-right">
              <router-link to="/register" class="text-light"><small>Registrar</small></router-link>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      model: {
        email: '',
        password: '',
        rememberMe: false,
      },
      message: null,

    };
  },
  methods: {
    onSubmit() {
      let vm = this;
      this.$http.acl.post('/login', {
        "email": this.model.email,
        "password": this.model.password,
      }, {
        headers: {
          'Authorization': null
        }
      }).then((response) => {
        localStorage.setItem('_ref', JSON.stringify(response.data.data));
        vm.$http.acl.interceptors.request.use(function (config) {
          config.headers.Authorization = 'Bearer ' + response.data.data.api_token;
          return config;
        });
        vm.$http.tickets.interceptors.request.use(function (config) {
          config.headers.Authorization = 'Bearer ' + response.data.data.api_token;
          return config;
        });
        vm.$http.estoque.interceptors.request.use(function (config) {
          config.headers.Authorization = 'Bearer ' + response.data.data.api_token;
          return config;
        });

        vm.$http.pedidos.interceptors.request.use(function (config) {
          config.headers.Authorization = 'Bearer ' + response.data.data.api_token;
          return config;
        });

        vm.$http.entregas.interceptors.request.use(function (config) {
          config.headers.Authorization = 'Bearer ' + response.data.data.api_token;
          return config;
        });

        this.$router.push('dashboard');
      }).catch((response) => {
        console.error(response)
        this.message = 'Erro ao fazer o login verifique as credenciais'
      })
    }
  }
};
</script>
