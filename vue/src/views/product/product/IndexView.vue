<script setup>
import { ref } from 'vue'
import { useStore } from '@/stores/store'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableData from '@/components/TableData.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'

const store = useStore()
let collection = ref([])
let error = ref(null)

const { err, collection: res } = await store.all('api/products')
error.value = err
if (res.data) {
  collection.value = res.data
}
</script>

<template>
  <HeaderOne>Produkty</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <table v-if="collection.length" class="w-full px-2 text-left">
    <thead>
      <TableHeaderRow>
        <TableHeader>L.P.</TableHeader>
        <TableHeader>#</TableHeader>
        <TableHeader>Name</TableHeader>
        <TableHeader>Slug</TableHeader>
      </TableHeaderRow>
    </thead>
    <tbody>
      <tr v-for="(item, index) in collection" :key="item.id">
        <TableData>{{ index + 1 }}</TableData>
        <TableData>{{ item.id }}</TableData>
        <TableData>{{ item.name }}</TableData>
        <TableData>{{ item.slug }}</TableData>
      </tr>
    </tbody>
  </table>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
