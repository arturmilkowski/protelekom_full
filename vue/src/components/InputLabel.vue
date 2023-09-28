<script setup>
defineProps({ for: { type: String, required: true } })
</script>

<template>
  <label :for="for" class="text-sm"><slot /></label>
</template>
