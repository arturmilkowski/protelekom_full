<script setup>
import axios from 'axios'
import { ref } from 'vue'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableData from '@/components/TableData.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'
import InputField from '@/components/InputField.vue'
import ValidationError from '@/components/ValidationError.vue'

let collection = ref([])
let error = ref(null)
let editedItem = ref(0)
let name = ref('')
let slug = ref('')
const validationError = ref(null)

try {
  const res = await axios('api/products/brands')
  collection.value = res.data.data
} catch (e) {
  error.value = e
}

const onDoubleClick = async (id) => {
  editedItem.value = id
  try {
    const res = await axios(`api/products/brands/${id}`)
    name.value = res.data.data.name
    slug.value = res.data.data.slug
  } catch (e) {
    error.value = e
  }
}

const onSubmit = async () => {
  const payload = {
    _method: 'PUT',
    name: name.value
  }

  let data = null
  try {
    data = await axios.post('api/products/brands/' + editedItem.value, payload)
    const updatedData = { slug: data.data.slug, name: data.data.name }
    collection.value = collection.value.map((item) =>
      item.id === editedItem.value ? { ...item, ...updatedData } : item
    )
  } catch (e) {
    if (e.code != 'ERR_BAD_REQUEST') {
      error.value = e
    }
    if (e.response?.data.errors) {
      validationError.value = e.response.data.errors
      // console.log('validationError', validationError.value.name[0])
    }
  }

  stopEditing()
}

const stopEditing = () => {
  editedItem.value = 0
}
</script>

<template>
  <HeaderOne>Firmy</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <p class="px-2 my-6">
    <RouterLink :to="{ name: 'products.brands.create' }">Dodaj</RouterLink>
  </p>
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
        <TableData @dblclick="onDoubleClick(item.id)">
          <!-- <RouterLink :to="{ name: 'posts.show', params: { id: item.id } }"> -->
          <template v-if="item.id == editedItem">
            <form @submit.prevent="onSubmit">
              <InputField
                @keyup.esc="stopEditing"
                v-model="name"
                id="name"
                placeholder="Pole obowiązkowe"
                ref="nameRef"
                required
              />
              <template v-if="validationError?.name">
                <template v-for="e in validationError.name" :key="e.name">
                  <ValidationError>{{ e }}</ValidationError>
                </template>
              </template>
            </form>
          </template>
          <template v-else>
            {{ item.name }}
          </template>
          <!-- </RouterLink> -->
        </TableData>
        <TableData>{{ item.slug }}</TableData>
      </tr>
    </tbody>
  </table>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
