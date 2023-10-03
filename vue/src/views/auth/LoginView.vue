<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import InputButton from '@/components/InputButton.vue'
import InputGroup from '@/components/InputGroup.vue'
// import InputLabel from '@/components/InputLabel.vue'
import InputField from '@/components/InputField.vue'
import ValidationError from '@/components/ValidationError.vue'

const router = useRouter()
const error = ref(null)
const validationError = ref(null)

const email = ref('artur-milkowski@tlen.pl')
const password = ref('12345678')

const onSubmit = () => {
  console.log('onSubmit', email.value, password.value)
}
</script>

<template>
  <HeaderOne>Logowanie</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form @submit.prevent="onSubmit" class="px-2 pt-2">
    <InputGroup>
      <InputField v-model="email" name="email" id="email" placeholder="Login" />
      <template v-if="validationError?.email">
        <template v-for="e in validationError.email" :key="e.name">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputField v-model="password" name="password" id="password" placeholder="Hasło" />
      <template v-if="validationError?.password">
        <template v-for="e in validationError.password" :key="e.name">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputButton />
  </form>
</template>
