<script setup>
import { ref } from 'vue'
import { useStore } from '@/stores/store'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableData from '@/components/TableData.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'
import InputField from '@/components/InputField.vue'
import InputButton from '@/components/InputButton.vue'
import ValidationError from '@/components/ValidationError.vue'

const store = useStore()
let collection = ref([])
let error = ref(null)
let editedItem = ref(0)
let name = ref('')
let slug = ref('')
const validationError = ref(null)

const { err, collection: res } = await store.all('api/products/categories')
error.value = err
collection.value = res.data

const onDoubleClick = async (id) => {
  editedItem.value = id
  const { err, data } = await store.getOne('api/products/categories', id)
  name.value = data.data.name
  slug.value = data.data.slug
  error.value = err
}

const onSubmit = async () => {
  const payload = {
    // _method: 'PUT',
    name: name.value
  }

  const { err, validationErr, data } = await store.update(
    'api/products/categories',
    editedItem.value,
    payload
  )
  // console.log(err.value, validationErr, data)
  error.value = err.value
  validationError.value = validationErr

  if (data) {
    const updatedData = { slug: data.data.slug, name: data.data.name }
    collection.value = collection.value.map((item) =>
      item.id === editedItem.value ? { ...item, ...updatedData } : item
    )
  }
  stopEditing()
}

const stopEditing = () => {
  editedItem.value = 0
}

const destroy = async (id) => {
  if (confirm('Potwierdź')) {
    // console.log('destroy', id)
    const { err, data } = await store.destroy('api/products/categories', id)
    // console.log(err, data)
    error.value = err

    const { err: err1, collection: res } = await store.all('api/products/categories')
    error.value = err1
    collection.value = res.data
  }

  stopEditing()
}
</script>

<template>
  <HeaderOne>Kategorie</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <p class="px-2 my-6">
    <RouterLink :to="{ name: 'products.categories.create' }">Dodaj</RouterLink>
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
          <template v-if="item.id == editedItem">
            <form @submit.prevent="onSubmit" novalidate>
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
            <form @submit.prevent="destroy(item.id)">
              <InputButton>Usuń</InputButton>
            </form>
            <form @submit.prevent="stopEditing">
              <InputButton>Anuluj</InputButton>
            </form>
          </template>
          <template v-else>
            {{ item.name }}
          </template>
        </TableData>
        <TableData>{{ item.slug }}</TableData>
      </tr>
    </tbody>
  </table>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
