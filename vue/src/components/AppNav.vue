<script setup>
import { useAuthStore } from '@/stores/auth'
const store = useAuthStore()
</script>

<template>
  <nav class="border-b-[1px] border-gray-300 py-2 px-2">
    <RouterLink :to="{ name: 'pages.index' }">Home</RouterLink>
    <RouterLink :to="{ name: 'pages.about' }">About</RouterLink>
    <RouterLink v-if="store.isAuth" :to="{ name: 'posts.index' }">Blog</RouterLink>
    <RouterLink v-if="store.isAuth" :to="{ name: 'products.home' }">Produkty</RouterLink>
    <RouterLink v-if="store.isGuest" :to="{ name: 'login' }">Zaloguj</RouterLink>
    <RouterLink v-else :to="{ name: 'logout' }">Wyloguj</RouterLink>
  </nav>
</template>
