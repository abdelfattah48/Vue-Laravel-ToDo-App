<template>
  <div v-if="visible" class="modal-overlay">
    <div class="modal">
      <h2>Confirm Deletion</h2>
      <p>{{ message }}</p>
      <div class="modal-actions">
        <button @click="$emit('cancel')">Cancel</button>
        <button @click="$emit('confirm')">Delete</button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  visible: Boolean,
  message: String
});
defineEmits(['cancel', 'confirm']);
</script>
