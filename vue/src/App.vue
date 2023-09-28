<script setup>
import { RouterView } from 'vue-router'
import AppNav from './components/AppNav.vue'
import AppFooter from '@/components/AppFooter.vue'
</script>

<template>
  <AppNav />
  <RouterView v-slot="{ Component }">
    <template v-if="Component">
      <Transition mode="out-in">
        <KeepAlive>
          <Suspense>
            <div><component :is="Component"></component></div>
            <template #fallback>Loading...</template>
          </Suspense>
        </KeepAlive>
      </Transition>
    </template>
  </RouterView>
  <AppFooter />
</template>
