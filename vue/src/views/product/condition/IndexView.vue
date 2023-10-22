<script setup>
import { ref } from 'vue'
import { useStore } from '@/stores/store'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'
import TableData from '@/components/TableData.vue'
import InputField from '@/components/InputField.vue'
import InputButton from '@/components/InputButton.vue'
import ValidationError from '@/components/ValidationError.vue'

const store = useStore()
let error = ref(null)
let collection = ref([])
let editedItem = ref(0)
let name = ref('')
let slug = ref('')
const validationError = ref(null)

const { err, collection: res } = await store.all('api/products/conditions')
error.value = err
collection.value = res.data

const onDoubleClick = async (id, name_) => {
  console.log('onDoubleClick', id, name_)
  editedItem.value = id
  console.log('editedItem', editedItem.value)
  //   const { err, data } = await store.getOne('api/products/conditions', id)
  //   name.value = data.data.name
  //   slug.value = data.data.slug
  //   error.value = err
  name.value = name_
}

const onSubmit = async () => {
  const payload = {
    name: name.value
  }
  console.log('onSubmit', payload)
  const { err, validationErr, data } = await store.update(
    'api/products/conditions',
    editedItem.value,
    payload
  )
  console.log(err.value, validationErr, data)
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
  // if (confirm('Potwierdź')) {
  console.log(collection.value)
  // console.log('destroy', id)
  // const { err, data } = await store.destroy('api/products/conditions', id)
  // console.log(err, data)
  // error.value = err
  const indexOfObject = collection.value.findIndex((object) => {
    return object.id === id
  })
  console.log(indexOfObject)
  collection.value.splice(indexOfObject, 1)
  console.log(collection.value)
  // }
}
</script>

<template>
  <HeaderOne>Stan produktu</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <p class="px-2 my-6">
    <!-- <RouterLink :to="{ name: 'products.categories.create' }">Dodaj</RouterLink> -->
    Dodaj
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
        <TableData class="w-1/12">{{ index + 1 }}</TableData>
        <TableData class="w-1/12">{{ item.id }}</TableData>
        <TableData @dblclick="onDoubleClick(item.id, item.name)">
          <template v-if="item.id == editedItem">
            <form @submit.prevent="onSubmit">
              <InputField
                @keyup.esc="stopEditing"
                v-model="name"
                id="name"
                placeholder="Pole obowiązkowe"
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
          <template v-else>{{ item.name }}</template>
        </TableData>
        <TableData>{{ item.slug }}</TableData>
      </tr>
    </tbody>
  </table>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
