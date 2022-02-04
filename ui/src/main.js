import Vue from 'vue';
import DashboardPlugin from './plugins/dashboard-plugin';
import App from './App.vue';


// router setup
import router from './routes/router';
import axios from "axios";
//import VueResource from 'vue-resource'

// plugin setup
Vue.use(DashboardPlugin);

//Vue.use(VueResource)


let loadFunction = config => {
  loadingShow()
  return config
}
let finishFunction = response => {
  loadingHide()
  return response
}
let errorFunction = error => {
  loadingHide()
  return Promise.reject(error)
}

const acl = axios.create({baseURL: 'http://127.0.0.1:8000'})
const stock = axios.create({baseURL: 'http://127.0.0.1:8001'})
const requests = axios.create({baseURL: 'http://127.0.0.1:8002'})
const deliveries = axios.create({baseURL: 'http://127.0.0.1:8003'})
const tickets = axios.create({baseURL: 'http://127.0.0.1:8004'})

acl.interceptors.request.use(loadFunction)
stock.interceptors.request.use(loadFunction)
requests.interceptors.request.use(loadFunction)
deliveries.interceptors.request.use(loadFunction)
tickets.interceptors.request.use(loadFunction)

acl.interceptors.response.use(finishFunction, errorFunction)
stock.interceptors.response.use(finishFunction, errorFunction)
requests.interceptors.response.use(finishFunction, errorFunction)
deliveries.interceptors.response.use(finishFunction, errorFunction)
tickets.interceptors.response.use(finishFunction, errorFunction)

if (localStorage.getItem('_ref')) {
  var api_token = JSON.parse(localStorage.getItem('_ref')).api_token
  acl.interceptors.request.use(function (config) {
    config.headers.Authorization = 'Bearer ' + api_token;
    return config;
  });
  tickets.interceptors.request.use(function (config) {
    config.headers.Authorization = 'Bearer ' + api_token;
    return config;
  });
  stock.interceptors.request.use(function (config) {
    config.headers.Authorization = 'Bearer ' + api_token;
    return config;
  });

  requests.interceptors.request.use(function (config) {
    config.headers.Authorization = 'Bearer ' + api_token;
    return config;
  });

  deliveries.interceptors.request.use(function (config) {
    config.headers.Authorization = 'Bearer ' + api_token;
    return config;
  });
}

Vue.prototype.$http = {
  acl: acl,
  estoque: stock,
  pedidos: requests,
  entregas: deliveries,
  tickets: tickets
}


/* eslint-disable no-new */
var app = new Vue({
  el: '#app',
  render: h => h(App),
  data() {
    return {
      user: null
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('_ref')
      this.$router.push('login');
    }
  },
  router
});

function loadingShow() {
  document.getElementById("loader").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}


function loadingHide() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}
