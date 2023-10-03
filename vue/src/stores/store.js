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
      err = e
      if (e.response?.data.errors) {
        validationErr = e.response.data.errors
      }
    }

    return { err, validationErr, data }
  }

  async function update(urlFragment, id, payload) {
    // const authStore = useAuthStore();
    let err = null
    let validationErr = []
    let data = null
    try {
      data = await axios.put(urlFragment + '\\' + id, payload)
    } catch (e) {
      // console.log('e', e)
      // validation error
      if (e.code != 'ERR_BAD_REQUEST') {
        err = e
      }
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
