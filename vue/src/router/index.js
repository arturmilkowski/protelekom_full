import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/page/HomeView.vue'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'pages.index',
      component: HomeView,
      meta: { auth: false }
    },
    {
      path: '/about',
      name: 'pages.about',
      component: () => import('../views/page/AboutView.vue'),
      meta: { auth: false }
    },
    {
      path: '/blog/posts',
      name: 'posts.index',
      component: () => import('../views/blog/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/blog/posts/create',
      name: 'posts.create',
      component: () => import('../views/blog/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/blog/posts/:id',
      name: 'posts.show',
      component: () => import('../views/blog/ShowView.vue'),
      meta: { auth: true }
    },
    {
      path: '/blog/posts/:id/edit',
      name: 'posts.edit',
      component: () => import('../views/blog/EditView.vue'),
      meta: { auth: true }
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/auth/LoginView.vue'),
      meta: { auth: false }
    },
    {
      path: '/logout',
      name: 'logout',
      component: () => import('../views/auth/LogoutView.vue'),
      meta: { auth: true }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/auth/RegisterView.vue'),
      meta: { auth: false }
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'not-found',
      component: () => import('../views/error/NotFoundView.vue'),
      meta: { auth: false }
    }
  ]
})

router.beforeEach((to) => {
  const store = useAuthStore()
  // console.log('store', store.isGuest)
  if (to.meta.auth === true && store.isGuest && to.name !== 'login') {
    return { name: 'login' }
  }
  // if (to.meta.auth === true && to.name !== 'login') {
  //   return { name: 'login' }
  // }
  // console.log('beforeEach', 'to auth:', to.meta.auth)
})
export default router
