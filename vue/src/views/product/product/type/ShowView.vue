<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useStore } from '@/stores/store'
import { useTrueFalseMessage } from '@/composables/useTrueFalseMessage'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableData from '@/components/TableData.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import ImageModal from '@/components/ImageModal.vue'

const route = useRoute()
const store = useStore()
let error = ref(null)
let item = ref(null)
const showModal = ref(false)

const url = `api/products/${route.params.product_id}/types`
const { err, data } = await store.getOne(url, route.params.id)
error.value = err
item.value = data?.data
let hideMessage
if (item.value) {
  const { message } = useTrueFalseMessage(item.value.hide)
  hideMessage = message
}

const destroy = async (id) => {
  if (confirm('Potwierdź')) {
    const url = `api/products/${route.params.product_id}/types/images`
    try {
      await store.destroy(url, id)
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
        <TableData>ID produktu</TableData>
        <TableData>{{ item.product_id }}</TableData>
      </tr>
      <tr>
        <TableData>Produkt</TableData>
        <TableData>{{ item.product }}</TableData>
      </tr>
      <tr>
        <TableData>Nazwa</TableData>
        <TableData>{{ item.name }}</TableData>
      </tr>
      <tr>
        <TableData>Cena [zł]</TableData>
        <TableData>{{ item.price }}</TableData>
      </tr>
      <tr>
        <TableData>Cena promocyjna [zł]</TableData>
        <TableData>{{ item.promo_price }}</TableData>
      </tr>
      <tr>
        <TableData>Stan</TableData>
        <TableData>{{ item.condition }}</TableData>
      </tr>
      <tr>
        <TableData>Ilość</TableData>
        <TableData>{{ item.quantity }}</TableData>
      </tr>
      <tr>
        <TableData>Ukryty</TableData>
        <TableData>{{ hideMessage }}</TableData>
      </tr>
      <tr>
        <TableData>Opis</TableData>
        <TableData>{{ item.description }}</TableData>
      </tr>
      <tr>
        <TableData>Grafika</TableData>
        <TableData>
          <template v-if="item.img">
            <a href="#" id="show-modal" @click="showModal = true">
              <img :src="item.img" width="200" />
            </a>
            <a @click="destroy(route.params.id)" href="#usunGrafike" class="btn btn-danger">Usuń</a>
          </template>
          <template v-else>&mdash;</template>
        </TableData>
      </tr>
    </tbody>
  </table>
  <BtnGroup class="mb-12">
    <RouterLink :to="{ name: 'products.types.index', params: { id: route.params.product_id } }"
      >Powrót</RouterLink
    >
    Edytuj
  </BtnGroup>
</template>
