<script setup>
import axios from 'axios'
import { useRoute } from 'vue-router'
import HeaderOne from '@/components/HeaderOne.vue'
import AppAlert from '@/components/AppAlert.vue'
import BtnGroup from '@/components/BtnGroup.vue'
import TableData from '@/components/TableData.vue'

const route = useRoute()

let error = null
let item = null

try {
  const res = await axios(`api/blog/posts/${route.params.id}`)
  item = res.data.data
} catch (e) {
  error = e
}

const destroy = async (id) => {
  if (confirm('Potwierdź')) {
    try {
      await axios.delete('api/blog/posts/images/' + id)
    } catch (e) {
      error.value = e
    }
    item.img = null
  }
}
</script>

<template>
  <HeaderOne>Wpis</HeaderOne>
  <AppAlert v-if="error" type="danger">{{ error.message }}</AppAlert>
  <table v-if="item" class="w-full px-2">
    <tbody>
      <tr>
        <TableData>#</TableData>
        <TableData>{{ item.id }}</TableData>
      </tr>
      <tr>
        <TableData>Tytuł</TableData>
        <TableData>{{ item.title }}</TableData>
      </tr>
      <tr>
        <TableData>Przyjazny adres</TableData>
        <TableData>{{ item.slug }}</TableData>
      </tr>
      <tr>
        <TableData>Wstęp</TableData>
        <TableData>{{ item.intro }}</TableData>
      </tr>
      <tr>
        <TableData>Treść</TableData>
        <TableData>{{ item.content }}</TableData>
      </tr>
      <tr>
        <TableData>Grafika</TableData>
        <TableData>
          <template v-if="item.img">
            <img :src="item.img" width="200" />
            <a @click="destroy(route.params.id)" href="#usunGrafike" class="btn btn-danger">Usuń</a>
          </template>
          <template v-else>&mdash;</template>
        </TableData>
      </tr>
      <tr>
        <TableData>Opis strony</TableData>
        <TableData>{{ item.site_description }}</TableData>
      </tr>
      <tr>
        <TableData>Słowa kluczowe</TableData>
        <TableData>{{ item.site_keyword }}</TableData>
      </tr>
      <tr>
        <TableData>Wstęp</TableData>
        <TableData>{{ item.intro }}</TableData>
      </tr>
      <tr>
        <TableData>Zaakceptowany</TableData>
        <TableData>{{ item.approved }}</TableData>
      </tr>
      <tr>
        <TableData>Opublikowany</TableData>
        <TableData>{{ item.published }}</TableData>
      </tr>
      <tr>
        <TableData>Utworzono</TableData>
        <TableData>{{ item.created_at }}</TableData>
      </tr>
      <tr>
        <TableData>Edytowano</TableData>
        <TableData>{{ item.updated_at }}</TableData>
      </tr>
    </tbody>
  </table>
  <BtnGroup>
    <RouterLink :to="{ name: 'posts.index' }">Powrót</RouterLink>
    <template v-if="item">
      <RouterLink :to="{ name: 'posts.edit', params: { id: item.id } }">Edytuj</RouterLink>
    </template>
  </BtnGroup>
</template>
