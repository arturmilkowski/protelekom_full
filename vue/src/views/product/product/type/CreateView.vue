<script setup>
import { ref, reactive } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import InputButton from '@/components/InputButton.vue'
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
const error = ref(null)
const validationError = ref(null)
let conditions = []

const item = reactive({
  product_id: route.params.id,
  condition_id: 1,
  name: '',
  price: null,
  promo_price: null,
  quantity: 1,
  hide: 0,
  img: null
})

const { err: conditionErr, collection: conditionCollection } =
  await store.all('api/products/conditions')
error.value = conditionErr
if (conditionCollection.data) {
  conditions = conditionCollection.data
}

const fileChange = async (event) => {
  item.img = event.target.files[0]
}

const onSubmit = async () => {
  // console.log(item)
  const url = `api/products/${route.params.id}/types`
  // console.log(url)

  const { err, validationErr, data } = await store.createPostForm(url, item)
  console.log(err, validationErr, data)
  error.value = err
  validationError.value = validationErr

  if (data?.status == 201) {
    router.push({ name: 'products.types.index', params: { id: route.params.id } })
  }
}
</script>

<template>
  <HeaderOne>Dodawanie</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form @submit.prevent="onSubmit" class="mx-2">
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
  <BtnGroup>
    <RouterLink :to="{ name: 'products.types.index', params: { id: route.params.id } }"
      >Powrót</RouterLink
    >
  </BtnGroup>
</template>
