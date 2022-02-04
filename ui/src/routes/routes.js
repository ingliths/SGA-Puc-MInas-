import DashboardLayout from '@/views/Layout/DashboardLayout.vue';
import AuthLayout from '@/views/Pages/AuthLayout.vue';

import NotFound from '@/views/NotFoundPage.vue';

const routes = [
  {
    path: '/',
    redirect: 'dashboard',
    component: DashboardLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Dashboard.vue')
      },
      {
        path: '/icons',
        name: 'icons',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Icons.vue')
      },
      {
        path: '/deliveries',
        name: 'Entregas',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Deliveries')
      },
      {
        path: '/requests',
        name: 'Pedidos',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Requests')
      },
      {
        path: '/vendors',
        name: 'Fornecedores',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Vendors.vue')
      },
      {
        path: '/categories',
        name: 'Categorias',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Categories.vue')
      },
      {
        path: '/products',
        name: 'Produtos',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Products.vue')
      },
      {
        path: '/tickets',
        name: 'Tickets',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Tickets.vue')
      }
    ]

  },
  {
    path: '/',
    redirect: 'login',
    component: AuthLayout,
    children: [
      {
        path: '/login',
        name: 'login',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Pages/Login.vue')
      },
      {
        path: '/register',
        name: 'register',
        component: () => import(/* webpackChunkName: "demo" */ '../views/Pages/Register.vue')
      },
      { path: '*', component: NotFound }
    ]
  }
];

export default routes;
