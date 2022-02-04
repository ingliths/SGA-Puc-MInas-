<template>
  <div>
    <base-header class="pb-6 pb-8 pt-5  bg-gradient-success">
      <!-- Card stats -->

    </base-header>
    <b-container fluid class="mt--7">
      <b-row>
        <b-col>
          <b-card no-body class="p-3">
            <b-form @submit="onSave">
              <b-row>
                <b-col>
                  <b-form-group label="Transportadora:">
                    <b-form-input
                      v-model="form.shipping_company"
                      required
                    ></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>
              <b-row>
                <b-col>
                  <b-form-group label="Pedido:">
                    <b-form-select v-model="form.pedido_id" :options="requests"></b-form-select>
                  </b-form-group>
                </b-col>

              </b-row>


              <b-button type="submit" variant="primary">Salvar <span v-if="form.id">Alteração</span></b-button>
              <b-button v-if="form.id" @click="reset()" type="button" variant="danger">Cancelar</b-button>
            </b-form>

            <h3 class="mt-4 mb-2">Listagem</h3>

            <b-table-simple responsive striped>
              <b-thead>
                <b-tr>
                  <b-th>ID</b-th>
                  <b-th>Pedido</b-th>
                  <b-th>Transportadora</b-th>
                  <b-th>Rastreio</b-th>
                  <b-th>Ações</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr v-for="item in items" :key="item.id">
                  <b-td>{{ item.id }}</b-td>
                  <b-td>{{ item.pedido_id }}</b-td>
                  <b-td>{{ item.shipping_company }}</b-td>
                  <b-td>{{ item.track_code }}</b-td>
                  <b-td>
                    <a @click="form = item" class="btn btn-sm btn-info">Editar</a>
                    <a @click="destroy(item)" class="btn btn-sm btn-danger">Deletar</a>
                  </b-td>
                </b-tr>

              </b-tbody>
            </b-table-simple>
          </b-card>
        </b-col>
      </b-row>
      <div class="mt-5"></div>
    </b-container>
  </div>
</template>
<script>

export default {
  data() {
    return {
      form: {
        id: null,
        pedido_id: '',
        shipping_company: '',
        track_code: '',
      },
      items: [],
      path: '/deliveries',
      requests: [],

    };
  },
  mounted() {
    this.reset()
    this.getItems()
    this.getPedidos()
  },
  methods: {
    onSave() {
      let app = this;
      let url = this.path
      if (this.form.id) {
        this.form['_method'] = 'patch'
        url = this.path + '/' + this.form.id
      }
      this.$http.entregas.post(url, this.form)
        .then((response) => {
          app.getItems()
          app.setStatus(app.form.pedido_id)
          app.reset()
        })
        .catch((err) => {
          alert('Error')
        })
    },
    getItems() {
      let app = this;
      this.$http.entregas.get(this.path).then((response) => {
        app.items = response.data.data;
      })
    },
    getPedidos() {
      let app = this;
      this.$http.pedidos.get('/requests').then((response) => {
        app.requests = response.data.data.map(function (el) {
          return {
            value: el.id,
            text: `${el.id} - ${el.client}`,
          }
        });
      })
    },

    setStatus(id) {
      let app = this;

      this.$http.pedidos.get('/requests/' + id).then((response) => {
        let data = response.data.data
        data['_method'] = 'patch'
        data['status'] = 'NA TRANSPORTADORA'
        this.$http.pedidos.post('/requests/' + id, data).then((response) => {
        })
      })

    },

    reset() {
      this.form = {
        id: null,
        pedido_id: '',
        shipping_company: '',
        track_code: '',

      }
    },
    destroy(item) {
      let app = this;
      let url = this.path + '/' + item.id
      if (confirm("Tem certeza")) {
        this.$http.entregas.delete(url)
          .then((response) => {
            app.getItems()
          })
          .catch((err) => {
            alert('Error')
          })
      }
    },
  }
};
</script>
<style>
.el-table.table-dark {
  background-color: #172b4d;
  color: #f8f9fe;
}

.el-table.table-dark th,
.el-table.table-dark tr {
  background-color: #172b4d;
}

.el-table.table-dark td,
.el-table.table-dark th.is-leaf {
  border-bottom: none;
}
</style>
