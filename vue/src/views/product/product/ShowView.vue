<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableData from '@/components/TableData.vue'
import BtnGroup from '@/components/BtnGroup.vue'

const route = useRoute()
const store = useStore()
let error = null
let item = null

const { err, data } = await store.getOne('api/products', route.params.id)
error = err
item = data.data
// console.log(err, data.data)
// console.log(error, item)
</script>

<template>
  <HeaderOne>Produkt</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <table v-if="item" class="w-full px-2">
    <tbody>
      <tr>
        <TableData>#</TableData>
        <TableData>{{ item.id }}</TableData>
      </tr>
      <tr>
        <TableData>Firma</TableData>
        <TableData>{{ item.brand_id }}</TableData>
      </tr>
      <tr>
        <TableData>Kategoria</TableData>
        <TableData>{{ item.category_id }}</TableData>
      </tr>
      <tr>
        <TableData>Nazwa</TableData>
        <TableData>{{ item.name }}</TableData>
      </tr>
      <tr>
        <TableData>Slug</TableData>
        <TableData>{{ item.slug }}</TableData>
      </tr>
      <tr>
        <TableData>Opis</TableData>
        <TableData>{{ item.description }}</TableData>
      </tr>
      <tr>
        <TableData>Zdjęcie</TableData>
        <TableData>{{ item.img }}</TableData>
      </tr>
      <tr>
        <TableData>Opis strony</TableData>
        <TableData>{{ item.site_description }}</TableData>
      </tr>
      <tr>
        <TableData>Słowa kluczowe</TableData>
        <TableData>{{ item.site_keyword }}</TableData>
      </tr>
      <tr>
        <TableData>Ukryj produkt</TableData>
        <TableData>{{ item.hide }}</TableData>
      </tr>
      <tr>
        <TableData>Utworzono</TableData>
        <TableData>{{ item.created_at }}</TableData>
      </tr>
      <tr>
        <TableData>Edytowano</TableData>
        <TableData>{{ item.updated_at }}</TableData>
      </tr>
    </tbody>
  </table>
  <BtnGroup>
    <RouterLink :to="{ name: 'products.products.index' }">Powrót</RouterLink>
    <!-- <template v-if="item">
      <RouterLink :to="{ name: 'posts.edit', params: { id: item.id } }">Edytuj</RouterLink>
    </template> -->
  </BtnGroup>
</template>
