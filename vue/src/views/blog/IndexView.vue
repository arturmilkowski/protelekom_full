<script setup>
import axios from 'axios'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableData from '@/components/TableData.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'

let collection = []
let error = null
try {
  const res = await axios('api/blog/posts')
  collection = res.data.data
  // console.log(res.data.data)
} catch (e) {
  error = e
  // console.log(error)
}
// console.log(collection, err)
</script>

<template>
  <HeaderOne>Wpisy</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <p class="px-2 my-6">
    <RouterLink :to="{ name: 'posts.create' }">Dodaj</RouterLink>
  </p>
  <table v-if="collection.length" class="w-full px-2 text-left">
    <thead>
      <TableHeaderRow>
        <TableHeader>L.P.</TableHeader>
        <TableHeader>#</TableHeader>
        <TableHeader>Title</TableHeader>
      </TableHeaderRow>
    </thead>
    <tbody>
      <tr v-for="(item, index) in collection" :key="item.id">
        <TableData>{{ index + 1 }}</TableData>
        <TableData>{{ item.id }}</TableData>
        <TableData>
          <RouterLink :to="{ name: 'posts.show', params: { id: item.id } }">
            {{ item.title }}
          </RouterLink>
        </TableData>
      </tr>
    </tbody>
  </table>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
