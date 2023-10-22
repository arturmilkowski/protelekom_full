<script setup>
import { ref, reactive } from 'vue'
import { useStore } from '@/stores/store'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import TableHeader from '@/components/TableHeader.vue'
import TableHeaderRow from '@/components/TableHeaderRow.vue'
import TableData from '@/components/TableData.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputField from '@/components/InputField.vue'
// import InputButton from '@/components/InputButton.vue'
import ValidationError from '@/components/ValidationError.vue'
import CreateModal from '@/components/CreateModal.vue'

const store = useStore()
const showModal = ref(false)
let error = ref(null)
let collection = ref([])
let editedItem = ref(0)
let name = ref('')
const createdItem = reactive({ name: '' })
const validationError = ref(null)

const { err, collection: res } = await store.all('api/products/conditions')
error.value = err
collection.value = res.data

const onDoubleClick = async (id, name_) => {
  editedItem.value = id
  name.value = name_
}

const onSubmit = async () => {
  const payload = {
    name: name.value
  }

  const { err, validationErr, data } = await store.update(
    'api/products/conditions',
    editedItem.value,
    payload
  )
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

const destroy = async (id) => {
  if (confirm('Potwierdź')) {
    const { err, data } = await store.destroy('api/products/conditions', id)
    error.value = err
    if (data?.status == 204) {
      const indexOfObject = collection.value.findIndex((object) => {
        return object.id === id
      })
      collection.value.splice(indexOfObject, 1)
    }
  }
}

const onCreate = async () => {
  const { err, validationErr, data } = await store.create('api/products/conditions', createdItem)
  error.value = err
  validationError.value = validationErr

  if (data?.status == 201) {
    collection.value.unshift(data.data)
    showModal.value = false
  }
}

const stopEditing = () => {
  editedItem.value = 0
}
</script>

<template>
  <HeaderOne>Stan produktu</HeaderOne>
  <Teleport to="body">
    <CreateModal :show="showModal" @close="showModal = false">
      <template #header>
        <h3>Dodawanie</h3>
      </template>
      <template #body>
        <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
        <form @submit.prevent="onCreate">
          <InputLabel for="name">Nazwa</InputLabel>
          <InputField v-model="createdItem.name" id="name" placeholder="Pole obowiązkowe" />
          <template v-if="validationError?.name">
            <template v-for="e in validationError.name" :key="e.name">
              <ValidationError>{{ e }}</ValidationError>
            </template>
          </template>
          <!-- <InputButton /> -->
        </form>
      </template>
    </CreateModal>
  </Teleport>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <p class="px-2 my-6">
    <a href="#create" @click="showModal = true">Dodaj</a>
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
            <span class="inline-flex items-baseline">
              <form @submit.prevent="onSubmit">
                <!-- <InputField
                @keyup.esc="stopEditing"
                v-model="name"
                id="name"
                placeholder="Pole obowiązkowe"
                required
              /> -->
                <input
                  @keyup.esc="stopEditing"
                  v-model="name"
                  type="text"
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
              <button @click="destroy(item.id)">Usuń</button>
              <button @click="stopEditing">Anuluj</button>
            </span>
          </template>
          <template v-else>{{ item.name }}</template>
        </TableData>
        <TableData>{{ item.slug }}</TableData>
      </tr>
    </tbody>
  </table>
  <AppAlert v-else>Brak danych</AppAlert>
</template>
