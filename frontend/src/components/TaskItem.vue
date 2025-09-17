<template>
  <li class="task-item">
    <div class="task-info">
      <strong>{{ task.title }}</strong><br />
      <small>{{ task.description }}</small>
    </div>

    <div class="action-menu">
      <button @click="$emit('toggleMenu', task.id)">⋮</button>
      <div v-if="openMenuId === task.id" class="dropdown">
        <button @click="$emit('details', task)">📄 Details</button>
        <button @click="$emit('edit', task)">✏️ Edit</button>
        <button @click="$emit('delete', task.id)">🗑️ Delete</button>
      </div>
    </div>
  </li>
</template>

<script setup>
defineProps({
  task: Object,
  openMenuId: [Number, String]
});
</script>
