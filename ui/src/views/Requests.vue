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
                  <b-form-group label="Cliente:">
                    <b-form-input
                      v-model="form.client"
                      required
                    ></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col>
                  <b-form-group label="Endereço:">
                    <b-form-input
                      v-model="form.address"
                      required
                    ></b-form-input>
                  </b-form-group>
                </b-col>
              </b-row>
              <b-row v-for="(item, index) in form.products" :key="index">
                <b-col>
                  <b-form-group label="Produto:">
                    <b-form-select v-model="form.products[index].id" :options="products"></b-form-select>
                  </b-form-group>
                </b-col>
                <b-col cols="3">
                  <b-form-group label="Quantity:">
                    <b-form-input
                      type="number"
                      v-model="form.products[index].quantity"
                      required
                    ></b-form-input>
                  </b-form-group>
                </b-col>
                <b-col cols="1">
                  <b-form-group label="Remover">
                  <b-button @click="removeItem(index)" type="button" variant="danger">Remover</b-button>
                  </b-form-group>
                </b-col>
              </b-row>
              <b-row>
                <b-col cols="1">
                <b-form-group >
                <b-button @click="addItem()" type="button" variant="info">Adicionar</b-button>
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
                  <b-th>Cliente</b-th>
                  <b-th>Endereço</b-th>
                  <b-th>Status</b-th>
                  <b-th>Ações</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr v-for="item in items" :key="item.id">
                  <b-td>{{ item.id }}</b-td>
                  <b-td>{{ item.client }}</b-td>
                  <b-td>{{ item.address }}</b-td>
                  <b-td>{{ item.status }}</b-td>
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
      form: null,
      items: [],
      path: '/requests',
      products: [],

    };
  },
  mounted() {
    this.reset()
    this.getItems()
    this.getProducts()
  },
  methods: {
    onSave() {
      let app = this;
      let url = this.path
      if (this.form.id) {
        this.form['_method'] = 'patch'
        url = this.path + '/' + this.form.id
      }
      this.$http.pedidos.post(url, this.form)
        .then((response) => {
          app.getItems()
          app.reset()
        })
        .catch((err) => {
          alert('Error')
        })
    },
    getItems() {
      let app = this;
      this.$http.pedidos.get(this.path).then((response) => {
        app.items = response.data.data;
      })
    },
    getProducts() {
      let app = this;
      this.$http.estoque.get('/products').then((response) => {
        app.products = response.data.data.map(function (el) {
          return {
            value: el.id,
            text: el.description,
          }
        });
      })
    },
    reset() {
      this.form = {
        id: null,
        client: '',
        address: '',
        products: [],

      }
    },
    destroy(item) {
      let app = this;
      let url = this.path + '/' + item.id
      if (confirm("Tem certeza")) {
        this.$http.pedidos.delete(url)
          .then((response) => {
            app.getItems()
          })
          .catch((err) => {
            alert('Error')
          })
      }
    },
    addItem() {
      this.form.products.push({
        id: null,
        quantity: 1
      })
    },
    removeItem(index) {
      this.form.products.splice(index, 1);
    }
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
