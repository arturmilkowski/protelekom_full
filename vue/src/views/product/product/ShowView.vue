<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from '@/stores/store'
import { useTrueFalseMessage } from '@/composables/useTrueFalseMessage'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'
import TableData from '@/components/TableData.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import ImageModal from '@/components/ImageModal.vue'

const route = useRoute()
const store = useStore()
let error = null
let item = ref(null)
const showModal = ref(false)

const { err, data } = await store.getOne('api/products', route.params.id)
error = err
item.value = data.data
item.value.hide = Boolean(item.value.hide)
const { message: hideMessage } = useTrueFalseMessage(item.value.hide)

const destroy = async (id) => {
  if (confirm('Potwierdź')) {
    try {
      await store.destroy('api/products/images', id)
    } catch (e) {
      error.value = e
    }

    item.value.img = null
  }
}
</script>

<template>
  <Teleport to="body">
    <ImageModal :show="showModal" :img="item.img" @close="showModal = false" />
  </Teleport>
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
        <TableData>{{ item.brand }}</TableData>
      </tr>
      <tr>
        <TableData>Kategoria</TableData>
        <TableData>{{ item.category }}</TableData>
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
        <TableData>
          <template v-if="item.img">
            <!-- <button id="show-modal" @click="showModal = true">Show Modal</button> -->
            <a href="#" id="show-modal" @click="showModal = true">
              <img :src="item.img" width="200" />
            </a>
            <a @click="destroy(route.params.id)" href="#usunGrafike" class="btn btn-danger">Usuń</a>
          </template>
          <template v-else>&mdash;</template>
        </TableData>
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
        <TableData>{{ item.hide }} | {{ hideMessage }}</TableData>
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
  <BtnGroup class="mb-12">
    <RouterLink :to="{ name: 'products.index' }">Powrót</RouterLink>
    <template v-if="item">
      <RouterLink :to="{ name: 'products.edit', params: { id: item.id } }">Edytuj</RouterLink>
    </template>
    <RouterLink :to="{ name: 'products.types.index', params: { id: item.id } }">Typy</RouterLink>
  </BtnGroup>
  <!-- <div>{{ item.types }}</div> -->
  <HeaderOne>Typu (rodzaje) produktu</HeaderOne>
  <table v-if="item.types.length" class="w-full px-2 text-left">
    <thead>
      <TableHeaderRow>
        <TableHeader>L.P.</TableHeader>
        <TableHeader>#</TableHeader>
        <TableHeader>Nazwa</TableHeader>
        <TableHeader>Cena [zł]</TableHeader>
        <TableHeader>Cena promocyjna [zł]</TableHeader>
        <TableHeader>Ilość</TableHeader>
        <TableHeader>Ukryty</TableHeader>
      </TableHeaderRow>
    </thead>
    <tbody>
      <tr v-for="(type, index) in item.types" :key="type.id">
        <TableData>{{ index + 1 }}</TableData>
        <TableData>{{ type.id }}</TableData>
        <TableData>{{ type.name }}</TableData>
        <TableData>{{ type.price }}</TableData>
        <TableData>{{ type.promo_price }}</TableData>
        <TableData>{{ type.quantity }}</TableData>
        <TableData>{{ type.hide }}</TableData>
      </tr>
    </tbody>
  </table>
  <AppAlert v-else>Brak typów produktu</AppAlert>
</template>
