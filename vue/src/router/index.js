import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/page/IndexView.vue'
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
      path: '/products/index',
      name: 'products.index',
      component: () => import('../views/product/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/brands',
      name: 'products.brands.index',
      component: () => import('../views/product/brand/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/brands/create',
      name: 'products.brands.create',
      component: () => import('../views/product/brand/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/categories',
      name: 'products.categories.index',
      component: () => import('../views/product/category/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/categories/create',
      name: 'products.categories.create',
      component: () => import('../views/product/category/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/products',
      name: 'products.products.index',
      component: () => import('../views/product/product/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/products/:id',
      name: 'products.products.show',
      component: () => import('../views/product/product/ShowView.vue'),
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
