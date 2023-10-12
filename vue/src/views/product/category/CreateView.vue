<script setup>
import { ref, reactive } from 'vue'
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

const onSubmit = async () => {
  const { err, validationErr, data } = await store.create('api/products/categories', item)
  error.value = err
  validationError.value = validationErr

  if (data?.status == 201) {
    router.push({ name: 'products.categories.index' })
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
    <InputButton />
  </form>
  <BtnGroup>
    <RouterLink :to="{ name: 'products.categories.index' }">Powrót</RouterLink>
  </BtnGroup>
</template>
