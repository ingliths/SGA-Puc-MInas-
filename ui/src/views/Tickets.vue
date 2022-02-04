<template>
  <div>
    <base-header class="pb-6 pb-8 pt-5  bg-gradient-success">
      <!-- Card stats -->

    </base-header>
    <b-container fluid class="mt--7">
      <b-row>
        <b-col>
          <b-card no-body class="p-3">

            <h3 class="mt-4 mb-2">Listagem</h3>
            <b-modal id="modal-1" :title="'Entradas - Ticket '+ form.id" hide-footer>
              <h3>{{ form.description }}</h3>
              <b-jumbotron class="p-3" v-for="entry in  form.entries" :key="entry.id">
                {{ entry.text }}
                <br>
                <small>{{ entry.user }}</small>

              </b-jumbotron>
              <label>Digite sua resposta</label>
              <textarea v-model="responder" class="form-control" aria-placeholder="Sua resposta aqui"></textarea>

              <b-button class="mt-3" block @click="onResponder()">Responder</b-button>

            </b-modal>

            <b-table-simple responsive striped>
              <b-thead>
                <b-tr>
                  <b-th>ID</b-th>
                  <b-th>Descrição</b-th>
                  <b-th>Status</b-th>
                  <b-th>Cliente</b-th>
                  <b-th>Ações</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr v-for="item in items" :key="item.id">
                  <b-td>{{ item.id }}</b-td>
                  <b-td>{{ item.description }}</b-td>
                  <b-td>
                    <badge type="danger">{{ item.status }}</badge>
                  </b-td>
                  <b-td>{{ item.client }}</b-td>
                  <b-td>
                    <a @click="form = item" v-b-modal.modal-1 class="btn btn-sm btn-info">Visualizar</a>
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
      path: '/clients/tickets',
      responder: '',

    };
  },
  mounted() {
    this.reset()
    this.getItems()
  },
  methods: {
    onResponder() {
      let app = this;
      let url = '/clients/ticket/' + this.form.id + '/entry'
      this.$http.tickets.post(url, {text: this.responder})
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
      this.$http.tickets.get(this.path).then((response) => {
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
        this.$http.tickets.delete(url)
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
