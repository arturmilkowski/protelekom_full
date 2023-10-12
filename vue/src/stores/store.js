import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useStore = defineStore('store', () => {
  async function all(urlFragment) {
    let collection = []
    let err = null

    try {
      const res = await axios(urlFragment)
      collection = res.data
    } catch (e) {
      err = e
    }

    return { err, collection }
  }

  async function getOne(urlFragment, id) {
    let err = null
    let data = null
    try {
      const res = await axios(`${urlFragment}/${id}`)
      data = res.data
    } catch (e) {
      err = e
    }

    return { err, data }
  }

  async function create(urlFragment, payload) {
    // const authStore = useAuthStore();
    let err = null
    let validationErr = null
    let data = null
    try {
      data = await axios.post(urlFragment, payload)
    } catch (e) {
      if (e.response.status != 422) {
        err = e
      }
      // console.log('store error', e.response.status)
      if (e.response?.data.errors) {
        validationErr = e.response.data.errors
      }
    }

    return { err, validationErr, data }
  }

  async function update(urlFragment, id, payload) {
    // const authStore = useAuthStore();
    // payload.concat({_method: 'PUT'})
    let err = ref(null)
    let validationErr = []
    let data = null
    try {
      data = await axios.put(urlFragment + '\\' + id, payload)
    } catch (e) {
      // console.log('e', e)
      err.value = e
      /*
      if (e.code != 'ERR_BAD_REQUEST') {
        err.value = e
      }
      */
      if (e.response?.data.errors) {
        validationErr = e.response.data.errors
      }
    }

    return { err, validationErr, data }
  }

  async function destroy(urlFragment, id) {
    // const authStore = useAuthStore();
    let err = null
    let data = null
    try {
      data = await axios.delete(urlFragment + '\\' + id)
    } catch (e) {
      err = e
    }

    return { err, data }
  }

  return { all, getOne, create, update, destroy }
})
