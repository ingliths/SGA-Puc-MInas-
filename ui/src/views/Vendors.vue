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

              <b-form-group id="input-group-2" label="Nome do fornecedor:" label-for="input-2">
                <b-form-input
                  id="input-2"
                  v-model="form.name"
                  placeholder="Nome do fornecedor"
                  required
                ></b-form-input>
              </b-form-group>

              <b-button type="submit" variant="primary">Salvar <span v-if="form.id">Alteração</span></b-button>
              <b-button v-if="form.id" @click="reset()" type="button" variant="danger">Cancelar</b-button>
            </b-form>

            <h3 class="mt-4 mb-2">Listagem</h3>

            <b-table-simple responsive striped>
              <b-thead>
                <b-tr>
                  <b-th>ID</b-th>
                  <b-th>Nome</b-th>
                  <b-th>Ações</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr v-for="item in items" :key="item.id">
                  <b-td>{{ item.id }}</b-td>
                  <b-td>{{ item.name }}</b-td>
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
      path: '/vendors'

    };
  },
  mounted() {
    this.reset()
    this.getItems()
  },
  methods: {
    onSave() {
      let app = this;
      let url = this.path
      if (this.form.id) {
        this.form['_method'] = 'patch'
        url = this.path + '/' + this.form.id
      }
      this.$http.estoque.post(url, this.form)
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
      this.$http.estoque.get(this.path).then((response) => {
        app.items = response.data.data;
      })
    },
    reset() {
      this.form = {
        id: null,
        name: ''
      }
    },
    destroy(item) {
      let app = this;
      let url = this.path + '/' + item.id
      if (confirm("Tem certeza")) {
        this.$http.estoque.delete(url)
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
