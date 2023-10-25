<template>
  <footer class="border-t-[1px] border-gray-300 pt-4 px-2 mt-24 text-gray-600 text-sm">
    Root name: {{ $router.currentRoute.value.name }} &mdash; Path:
    {{ $router.currentRoute.value.path }} &mdash; Params:
    {{ $router.currentRoute.value.params }}
  </footer>
</template>
