<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import InputGroup from '@/components/InputGroup.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import InputButton from '@/components/InputButton.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputField from '@/components/InputField.vue'
import InputTextarea from '@/components/InputTextarea.vue'
import InputCheckbox from '@/components/InputCheckbox.vue'
import ValidationError from '@/components/ValidationError.vue'

const router = useRouter()
const error = ref(null)
const validationError = ref(null)

const item = reactive({
  user_id: '1',
  title: '',
  slug: '',
  intro: '',
  content: '',
  img: null,
  site_description: '',
  site_keyword: '',
  approved: true,
  published: true
})

const onSubmit = async () => {
  console.log('on sub')
  let data = null
  try {
    data = await axios.postForm('api/blog/posts', item)
    console.log(data)
  } catch (e) {
    error.value = e
    if (e.response?.data.errors) {
      validationError.value = e.response.data.errors
    }
  }

  if (data?.status == 201) {
    router.push({ name: 'posts.index' })
  }
}

const fileChange = async (event) => {
  item.img = event.target.files[0]
}
</script>

<template>
  <HeaderOne>Dodawanie</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form @submit.prevent="onSubmit" class="mx-2">
    <InputGroup>
      <InputLabel for="title">Tytuł</InputLabel>
      <InputField v-model="item.title" id="title" placeholder="Pole obowiązkowe" />
      <template v-if="validationError?.title">
        <template v-for="e in validationError.title" :key="e.title">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="intro">Wstęp</InputLabel>
      <InputTextarea v-model="item.intro" id="intro" placeholder="Pole nieobowiązkowe" />
      <template v-if="validationError?.intro">
        <template v-for="e in validationError.intro" :key="e.intro">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="content">Treść</InputLabel>
      <InputTextarea v-model="item.content" id="content" placeholder="Pole nieobowiązkowe" />
      <template v-if="validationError?.content">
        <template v-for="e in validationError.content" :key="e.content">
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
    <InputGroup>
      <InputLabel for="site_description">Opis strony</InputLabel>
      <InputField
        v-model="item.site_description"
        id="site_description"
        placeholder="Pole nieobowiązkowe"
      />
      <template v-if="validationError?.site_description">
        <template v-for="e in validationError.site_description" :key="e.site_description">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="site_keyword">Słowa kluczowe</InputLabel>
      <InputField v-model="item.site_keyword" id="site_keyword" placeholder="Pole nieobowiązkowe" />
      <template v-if="validationError?.site_keyword">
        <template v-for="e in validationError.site_keyword" :key="e.site_keyword">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputCheckbox v-model="item.approved" id="approved" label="Zaakceptowany" />
      <template v-if="validationError?.approved">
        <template v-for="e in validationError.approved" :key="e.approved">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputCheckbox v-model="item.published" id="published" label="Widoczny" />
      <template v-if="validationError?.published">
        <template v-for="e in validationError.published" :key="e.published">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputButton />
  </form>
  <BtnGroup>
    <RouterLink :to="{ name: 'posts.index' }">Powrót</RouterLink>
  </BtnGroup>
</template>
