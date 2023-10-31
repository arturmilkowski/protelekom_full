<script setup>
import { useAuthStore } from '@/stores/auth'
const store = useAuthStore()
</script>

<template>
  <!-- border-b-[1px] border-gray-300 -->
  <nav class="py-2 px-2">
    <RouterLink :to="{ name: 'pages.index' }">Home</RouterLink>
    <RouterLink :to="{ name: 'pages.about' }">About</RouterLink>
    <!-- v-if="store.isAuth" -->
    <RouterLink :to="{ name: 'posts.index' }">Blog</RouterLink>
    <!-- v-if="store.isAuth" -->
    <RouterLink :to="{ name: 'products.home' }">Produkty</RouterLink>
    <!-- v-if="store.isGuest" -->
    <RouterLink :to="{ name: 'login' }">Zaloguj</RouterLink>
    <!-- v-else -->
    <RouterLink :to="{ name: 'logout' }">Wyloguj</RouterLink>
  </nav>
</template>
