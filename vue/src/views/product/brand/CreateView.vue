<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from '@/stores/store'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import InputButton from '@/components/InputButton.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputField from '@/components/InputField.vue'
import ValidationError from '@/components/ValidationError.vue'

const router = useRouter()
const store = useStore()
const error = ref(null)
const validationError = ref(null)

const item = reactive({ name: '' })
const refName = ref(null)
const input = ref(null)

onMounted(() => {
  // refName.value.focus()
  console.log('on', refName)
  // input.value.focus()
  // console.log('input.value', input.value)
  // console.log('nameRef.value', nameRef.value)
})

const onSubmit = async () => {
  // console.log('onSubmit', item)
  const { err, validationErr, data } = await store.create('api/products/brands', item)
  error.value = err
  validationError.value = validationErr
  // console.log(err, validationErr, data)

  if (data?.status == 201) {
    router.push({ name: 'products.brands.index' })
  }
}
</script>

<template>
  <HeaderOne>Dodawanie</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form @submit.prevent="onSubmit" class="mx-2">
    <input ref="input" />
    <InputGroup>
      <InputLabel for="name">Nazwa</InputLabel>
      <!-- refName="nameRef" -->
      <InputField v-model="item.name" id="name" placeholder="Pole obowiązkowe" refName="name" />
      <template v-if="validationError?.name">
        <template v-for="e in validationError.name" :key="e.name">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputButton />
  </form>
  <BtnGroup>
    <RouterLink :to="{ name: 'products.brands.index' }">Powrót</RouterLink>
  </BtnGroup>
</template>
