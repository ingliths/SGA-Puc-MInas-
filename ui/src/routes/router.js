import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import {atob} from "buffer";

Vue.use(VueRouter);

// configure router
const router = new VueRouter({
  routes, // short for routes: routes
  linkActiveClass: 'active',
  scrollBehavior: (to, from ,savedPosition) => {
    if (savedPosition) {
      return savedPosition;
    }
    if (to.hash) {
      return { selector: to.hash };
    }
    return { x: 0, y: 0 };
  }
});

router.beforeEach((to, from, next) => {
  const currentUser = localStorage.getItem('_ref');
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

  if (requiresAuth && !currentUser) {
    const loginpath = window.location.pathname;
    next({ name: 'login', query: { from: loginpath } });
  } else if (!requiresAuth && currentUser) next('menu');
  else next();
});

export default router;
