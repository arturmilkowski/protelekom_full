<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useStore } from '@/stores/store'
import axios from 'axios'
import HeaderOne from '@/components/HeaderOne.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import InputButton from '@/components/InputButton.vue'
import AppAlert from '@/components/AppAlert.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputField from '@/components/InputField.vue'
import InputSelect from '@/components/InputSelect.vue'
import InputTextarea from '@/components/InputTextarea.vue'
import InputCheckbox from '@/components/InputCheckbox.vue'
import ValidationError from '@/components/ValidationError.vue'

const route = useRoute()
const router = useRouter()
const store = useStore()

let item = ref(null)
let conditions = []
let error = ref(null)
let validationError = ref(null)

const url = `api/products/${route.params.product_id}/types`
const { err, data } = await store.getOne(url, route.params.id)
error.value = err
item.value = data?.data

const { err: conditionErr, collection } = await store.all('api/products/conditions')
error.value = conditionErr
if (collection.data) {
  conditions = collection.data
}

watch(item.value, async (item) => {
  console.log(`item is ${item.name}`)
  const payload = { text: item.name }
  const res = await axios.post(`api/slugs`, payload)
  console.log(res)
})

// watch(item.name, async (newQuestion, oldQuestion) => {
//   console.log(item.name)
// })

const fileChange = async (event) => {
  item.value.img = event.target.files[0]
}

const onSubmit = async () => {
  if (typeof item.value.img == 'string') {
    delete item.value.img // send only images, not file name
  }

  const { err, validationErr, data } = await store.updatePostForm(
    `api/products/${route.params.product_id}/types`,
    item.value.id,
    item.value
  )
  error.value = err
  validationError.value = validationErr

  if (data?.status == 200) {
    router.push({
      name: 'products.types.show',
      params: { product_id: route.params.product_id, id: item.value.id }
    })
  }
}
</script>

<template>
  <HeaderOne>Edycja [{{ item.name }}]</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form v-if="item" @submit.prevent="onSubmit" class="mx-2">
    <InputGroup>
      <InputLabel for="name">Nazwa</InputLabel>
      <InputField v-model="item.name" id="name" placeholder="Pole obowiązkowe" />
      <template v-if="validationError?.name">
        <template v-for="e in validationError.name" :key="e.name">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="price">Cena</InputLabel>
      <InputField
        type="number"
        v-model="item.price"
        id="price"
        min="1"
        max="99999"
        step="1"
        placeholder="Pole obowiązkowe"
      />
      <template v-if="validationError?.price">
        <template v-for="e in validationError.price" :key="e.price">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="promo_price">Cena promocyjna</InputLabel>
      <InputField
        type="number"
        v-model="item.promo_price"
        id="promo_price"
        min="1"
        max="99999"
        step="1"
        placeholder="Pole nieobowiązkowe"
      />
      <template v-if="validationError?.promo_price">
        <template v-for="e in validationError.promo_price" :key="e.promo_price">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="quantity">Ilość</InputLabel>
      <InputField
        type="number"
        v-model="item.quantity"
        id="quantity"
        min="1"
        max="9999"
        placeholder="Pole obowiązkowe"
      />
      <template v-if="validationError?.promo_price">
        <template v-for="e in validationError.promo_price" :key="e.promo_price">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputCheckbox v-model="item.hide" id="hide" label="Ukryj" />
      <template v-if="validationError?.hide">
        <template v-for="e in validationError.hide" :key="e.hide">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="condition">Stan</InputLabel>
      <InputSelect
        v-model="item.condition_id"
        :items="conditions"
        id="condition"
        placeholder="Pole obowiązkowe"
      ></InputSelect>
      <template v-if="validationError?.condition">
        <template v-for="e in validationError.condition" :key="e.condition">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="description">Opis</InputLabel>
      <InputTextarea
        v-model="item.description"
        id="description"
        placeholder="Pole nieobowiązkowe"
      />
      <template v-if="validationError?.description">
        <template v-for="e in validationError.description" :key="e.description">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="img">Grafika</InputLabel>
      <input type="file" @change="fileChange" />
      <template v-if="validationError?.img">
        <template v-for="e in validationError.img" :key="e.img">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputButton />
  </form>
  <BtnGroup v-if="item">
    <RouterLink
      :to="{
        name: 'products.types.show',
        params: { product_id: route.params.product_id, id: item.id }
      }"
      >Powrót</RouterLink
    >
  </BtnGroup>
</template>
