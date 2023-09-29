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
    },
    {
      path: '/blog/posts',
      name: 'posts.index',
      component: () => import('../views/blog/IndexView.vue')
    },
    {
      path: '/blog/posts/create',
      name: 'posts.create',
      component: () => import('../views/blog/CreateView.vue')
    },
    {
      path: '/blog/posts/:id',
      name: 'posts.show',
      component: () => import('../views/blog/ShowView.vue')
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('../views/error/NotFoundView.vue')
    }
  ]
})

export default router
