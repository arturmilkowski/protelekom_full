<template>
  <nav class="border-b-[1px] border-gray-300 py-2 px-2">
    <RouterLink :to="{ name: 'pages.home' }">Home</RouterLink>
    <RouterLink :to="{ name: 'pages.about' }">About</RouterLink>
    <RouterLink :to="{ name: 'posts.index' }">Blog</RouterLink>
  </nav>
</template>
