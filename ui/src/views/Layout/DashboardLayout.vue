<template>
  <div class="wrapper">
    <notifications></notifications>
    <side-bar>
      <template slot="links">
        <sidebar-item
          :link="{
            name: 'Painel de controle',
            path: '/dashboard',
            icon: 'ni ni-tv-2 text-primary',
          }"
        >
        </sidebar-item>


        <sidebar-item
          :link="{
                name: 'Produtos',
                path: '/products',
                icon: 'ni ni-box-2 text-green'
              }">
        </sidebar-item>

        <sidebar-item
              :link="{
                name: 'Fornecedores',
                path: '/vendors',
                icon: 'ni ni-app text-orange'
              }">
        </sidebar-item>

        <sidebar-item
          :link="{
                name: 'Categorias',
                path: '/categories',
                icon: 'ni ni-archive-2 text-blue'
              }">
        </sidebar-item>

        <sidebar-item
          :link="{
                name: 'Pedidos',
                path: '/requests',
                icon: 'ni ni-basket text-blue'
              }">
        </sidebar-item>

        <sidebar-item
          :link="{
                name: 'Entregas',
                path: '/deliveries',
                icon: 'ni ni-delivery-fast text-blue'
              }">
        </sidebar-item>

        <sidebar-item
          :link="{
                name: 'Tickets',
                path: '/tickets',
                icon: 'ni ni-support-16 text-red'
              }">
        </sidebar-item>

      </template>

    </side-bar>
    <div class="main-content">
      <dashboard-navbar :type="$route.meta.navbarType"></dashboard-navbar>

      <div @click="$sidebar.displaySidebar(false)">
        <fade-transition :duration="200" origin="center top" mode="out-in">
          <!-- your content here -->
          <router-view></router-view>
        </fade-transition>
      </div>
      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<script>
  /* eslint-disable no-new */
  import PerfectScrollbar from 'perfect-scrollbar';
  import 'perfect-scrollbar/css/perfect-scrollbar.css';

  function hasElement(className) {
    return document.getElementsByClassName(className).length > 0;
  }

  function initScrollbar(className) {
    if (hasElement(className)) {
      new PerfectScrollbar(`.${className}`);
    } else {
      // try to init it later in case this component is loaded async
      setTimeout(() => {
        initScrollbar(className);
      }, 100);
    }
  }

  import DashboardNavbar from './DashboardNavbar.vue';
  import ContentFooter from './ContentFooter.vue';
  import DashboardContent from './Content.vue';
  import { FadeTransition } from 'vue2-transitions';

  export default {
    components: {
      DashboardNavbar,
      ContentFooter,
      DashboardContent,
      FadeTransition
    },
    methods: {
      initScrollbar() {
        let isWindows = navigator.platform.startsWith('Win');
        if (isWindows) {
          initScrollbar('sidenav');
        }
      }
    },
    beforeCreate() {
      this.$http.acl.get('users/profile')
        .then((response) => {
          this.$root.user = response.data.data
        })
        .catch((err) => {
         this.$root.logout()
        })
    },
    mounted() {
      this.initScrollbar()
    }
  };
</script>
<style lang="scss">
</style>
