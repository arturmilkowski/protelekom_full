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
      name: 'products.home',
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
      path: '/products/conditions',
      name: 'products.conditions.index',
      component: () => import('../views/product/condition/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products',
      name: 'products.index',
      component: () => import('../views/product/product/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/create',
      name: 'products.create',
      component: () => import('../views/product/product/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/:id',
      name: 'products.show',
      component: () => import('../views/product/product/ShowView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/:id/edit',
      name: 'products.edit',
      component: () => import('../views/product/product/EditView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/:id/types',
      name: 'products.types.index',
      component: () => import('../views/product/product/type/IndexView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/:id/types/create',
      name: 'products.types.create',
      component: () => import('../views/product/product/type/CreateView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/:product_id/types/:id',
      name: 'products.types.show',
      component: () => import('../views/product/product/type/ShowView.vue'),
      meta: { auth: true }
    },
    {
      path: '/products/:product_id/types/:id/edit',
      name: 'products.types.edit',
      component: () => import('../views/product/product/type/EditView.vue'),
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
  /*
  const store = useAuthStore()
  if (to.meta.auth === true && store.isGuest && to.name !== 'login') {
    return { name: 'login' }
  }
  */
})

export default router
