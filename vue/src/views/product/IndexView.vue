<template>
  <div class="flex mx-2 mt-12 gap-8">
    <RouterLink :to="{ name: 'products.brands.index' }">Firmy</RouterLink>
    <RouterLink :to="{ name: 'products.categories.index' }">Kategorie</RouterLink>
    <RouterLink :to="{ name: 'products.conditions.index' }">Stan</RouterLink>
    <RouterLink :to="{ name: 'products.products.index' }">Produkty</RouterLink>
  </div>
</template>
