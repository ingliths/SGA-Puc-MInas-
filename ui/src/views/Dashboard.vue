<template>
  <div>
    <base-header class="pb-6 pb-8 pt-5 pt-md-8 bg-gradient-success">
      <!-- Card stats -->
      <b-row>
        <b-col  md="4">
          <stats-card title="Total Pedidos"
                      type="gradient-red"
                      :sub-title="'' + requests"
                      icon="ni ni-basket text-white"
                      class="mb-4">

            <template slot="footer">
              <router-link class="text-nowrap" to="/requests">
                <i class="fas fa-info"></i> Detalhes
              </router-link>
            </template>
          </stats-card>
        </b-col>
        <b-col  md="4">
          <stats-card title="Total de entregas"
                      type="gradient-blue"
                      :sub-title="'' + deliveries"
                      icon="ni ni-bus-front-12 text-white"
                      class="mb-4">

            <template slot="footer">
              <router-link class="text-nowrap" to="/deliveries">
                <i class="fas fa-info"></i> Detalhes
              </router-link>
            </template>
          </stats-card>
        </b-col>
        <b-col  md="4">
          <stats-card title="Total de produtos"
                      type="gradient-green"
                      :sub-title="'' + products"
                      icon="ni ni-box-2 text-white"
                      class="mb-4">

            <template slot="footer">
              <router-link class="text-nowrap" to="/products">
                <i class="fas fa-info"></i> Detalhes
              </router-link>
            </template>
          </stats-card>
        </b-col>

      </b-row>
    </base-header>
  </div>
</template>
<script>


  // Tables

  export default {
    components: {

    },
    data() {
      return {
        products: 0,
        requests: 0,
        deliveries: 0,
      };
    },
    methods: {

    },
    mounted() {
      let app = this;
      this.$http.pedidos.get('/requests').then((response) => {
        app.requests = response.data.data.length;
      })
      this.$http.entregas.get('/deliveries').then((response) => {
        app.deliveries = response.data.data.length;
      })
      this.$http.estoque.get('/products').then((response) => {
        app.products = response.data.data.length;
      })
    }
  };
</script>
<style>
.el-table .cell{
  padding-left: 0px;
  padding-right: 0px;
}
</style>
