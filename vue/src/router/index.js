import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/page/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'pages.home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'pages.about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/page/AboutView.vue')
    }
  ]
})

export default router
