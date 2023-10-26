<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import TableData from '@/components/TableData.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'

const route = useRoute()
const store = useStore()
let collection = ref([])
let error = ref(null)

const url = `api/products/${route.params.id}/types`
const { err, collection: res } = await store.all(url)
error.value = err
if (res.data) {
  collection.value = res.data
}
</script>

<template>
  <HeaderOne>Typy produktu</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <p class="px-2 my-6">
    <RouterLink :to="{ name: 'products.types.create', params: { id: route.params.id } }"
      >Dodaj</RouterLink
    >
  </p>
  <table v-if="collection.length" class="w-full px-2 text-left">
    <thead>
      <TableHeaderRow>
        <TableHeader>L.P.</TableHeader>
        <TableHeader>#</TableHeader>
        <TableHeader>ID produktu</TableHeader>
        <TableHeader>Produkt</TableHeader>
        <TableHeader>Nazwa</TableHeader>
        <TableHeader>Cena [zł]</TableHeader>
        <TableHeader>Cena promocyjna [zł]</TableHeader>
        <TableHeader>Stan</TableHeader>
        <TableHeader>Ilość</TableHeader>
        <TableHeader>Ukryty</TableHeader>
      </TableHeaderRow>
    </thead>
    <tbody>
      <tr v-for="(item, index) in collection" :key="item.id">
        <TableData>{{ index + 1 }}</TableData>
        <TableData>{{ item.id }}</TableData>
        <TableData>{{ item.product_id }}</TableData>
        <TableData>{{ item.product }}</TableData>
        <TableData>
          <RouterLink
            :to="{
              name: 'products.types.show',
              params: { product_id: item.product_id, id: item.id }
            }"
          >
            {{ item.name }}
          </RouterLink>
        </TableData>
        <TableData>{{ item.price }}</TableData>
        <TableData>{{ item.promo_price }}</TableData>
        <TableData>{{ item.condition }}</TableData>
        <TableData>{{ item.quantity }}</TableData>
        <TableData>{{ item.hide }}</TableData>
      </tr>
    </tbody>
  </table>
  <AppAlert v-else>Brak danych</AppAlert>
  <BtnGroup>
    <RouterLink :to="{ name: 'products.show', params: { id: route.params.id } }">Powrót</RouterLink>
  </BtnGroup>
</template>
