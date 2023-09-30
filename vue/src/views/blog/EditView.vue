<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import InputGroup from '@/components/InputGroup.vue'
import InputButton from '@/components/InputButton.vue'
import InputLabel from '@/components/InputLabel.vue'
import InputField from '@/components/InputField.vue'
import InputTextarea from '@/components/InputTextarea.vue'
import InputCheckbox from '@/components/InputCheckbox.vue'
import ValidationError from '@/components/ValidationError.vue'

const route = useRoute()
const router = useRouter()
const error = ref(null)
const validationError = ref(null)

let item = null
try {
  const res = await axios(`api/blog/posts/${route.params.id}`)
  item = res.data.data

  item.approved = Boolean(item.approved)
  item.published = Boolean(item.published)
} catch (e) {
  error.value = e
}

const onSubmit = async () => {
  let img = null // send only if img is a file
  if (typeof item.img == 'object') {
    img = item.img
  }
  const payload = {
    _method: 'PUT',
    user_id: '1',
    title: item.title,
    intro: item.intro,
    content: item.content,
    img: img,
    site_description: item.site_description,
    site_keyword: item.site_keyword,
    approved: item.approved,
    published: item.published
  }

  let data = null
  try {
    data = await axios.postForm('api/blog/posts/' + route.params.id, payload, { _method: 'put' })
    console.log(data)
  } catch (e) {
    if (e.code != 'ERR_BAD_REQUEST') {
      error.value = e
    }
    if (e.response?.data.errors) {
      validationError.value = e.response.data.errors
    }
  }

  if (data?.status == 200) {
    router.push({ name: 'posts.show', params: { id: item.id } })
  }
}

const destroy = async (id) => {
  if (confirm('Potwierdź')) {
    let data = null
    try {
      data = await axios.delete('api/blog/posts/' + id)
    } catch (e) {
      error.value = e
    }

    if (data?.status == 204) {
      router.push({ name: 'posts.index' })
    }
  }
}

const fileChange = async (event) => {
  item.img = event.target.files[0]
}
</script>

<template>
  <HeaderOne>Edycja</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <form v-if="item" @submit.prevent="onSubmit">
    <InputGroup>
      <InputLabel for="title">Tytuł</InputLabel>
      <InputField v-model="item.title" name="title" id="title" placeholder="Pole obowiązkowe" />
      <template v-if="validationError?.title">
        <template v-for="e in validationError.title" :key="e.title">
          <ValidationError>{{ e }}</ValidationError>
        </template>
      </template>
    </InputGroup>
    <InputGroup>
      <InputLabel for="intro">Wstęp</InputLabel>
      <InputField v-model="item.intro" name="intro" id="intro" placeholder="Pole nieobowiązkowe" />
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
    <a @click="destroy(route.params.id)" href="#delete" class="btn btn-danger ml-3">Usuń</a>
  </form>
  <template v-if="item">
    <BtnGroup>
      <RouterLink :to="{ name: 'posts.show', params: { id: route.params.id } }">Powrót</RouterLink>
    </BtnGroup>
  </template>
</template>
