<template>
  <div v-if="visible" class="modal-overlay">
    <div class="modal">
      <h2>{{ title }}</h2>
      <form @submit.prevent="submit">
        <input v-model="form.title" placeholder="Task Title" :disabled="readonly" required />
        <textarea v-model="form.description" placeholder="Task Description" :disabled="readonly"></textarea>
        <input type="checkbox" v-model="form.done" v-if="!readonly"/>
        <div class="modal-actions">
          <button type="submit" v-if="!readonly">Save</button>
          <button type="button" @click="$emit('close')">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  visible: Boolean,
  task: Object,
  mode: { type: String, default: 'add' } // add, edit, details
});

const emit = defineEmits(['close', 'submit']);

const title = ref('');
const readonly = ref(false);
const form = ref({ title: '', description: '', done: false });

watch(() => props.task, (t) => {
  if (!t) return;
  form.value = { ...t };
  readonly.value = props.mode === 'details';
  title.value = props.mode === 'add' ? 'Add Task' :
                props.mode === 'edit' ? 'Edit Task' :
                'Task Details';
});
const submit = () => emit('submit', form.value);
</script>
