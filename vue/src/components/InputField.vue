<script setup>
defineProps({
  type: { type: String, default: 'text' },
  id: { type: String },
  placeholder: { type: String },
  modelValue: { type: [String, Number] }
  // refName: { type: String }
})
defineEmits(['update:modelValue'])
</script>

<template>
  <!-- :ref="refName" -->
  <input
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :type="type"
    :id="id"
    class="dark:bg-gray-400 dark:text-gray-900 border border-gray-400 dark:border-gray-400 hover:border-gray-900 dark:hover:border-gray-300 focus:outline-none focus:border-black dark:focus:border-gray-300 dark:focus:text-black p-1 w-full"
    :placeholder="placeholder"
  />
</template>
