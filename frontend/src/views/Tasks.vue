
<template>
  <div>
    <div class="auth-buttons">
        <button 
            @click="notif" 
            style="
                background-color: #f4f6f8; 
                color: white; 
                padding: 10px 20px; 
                border: none; 
                border-radius: 8px; 
                font-weight: bold; 
                cursor: pointer;
                transition: 0.3s;
            "
            class="bell-btn"
            >
        🔔
        </button>
      <button v-if="!isLoggedIn" @click="goLogin">Login</button>
      <button v-if="!isLoggedIn" @click="goRegister">Register</button>
      <button v-else @click="logout">Logout</button>

    </div>

    <!-- Contenu principal -->
    <div class="container">
      <h1 class="page-title"> My Tasks</h1>

      <!-- Bouton Ajouter une tâche -->
      <button class="add-btn" @click="openAddModal">+ Add Task</button>

      <!-- Liste des tâches -->
      <ul class="task-list">
<li v-for="task in [...(taskStore.tasks || [])]" :key="task.id" class="task-item">
          <div class="task-info">
            <strong>{{ task.title }}</strong><br />
            <small>{{ task.description }}</small>
          </div>

          <!-- Menu d'actions -->
          <div class="action-menu">
            <button class="menu-btn" @click="toggleMenu(task.id)">⋮</button>

            <!-- Dropdown -->
            <div v-if="openMenuId === task.id" class="dropdown">
              <button @click="openDetailsModal(task)">📄 Details</button>
              <button @click="openEditModal(task)">✏️ Edit</button>
                <button class="delete-btn" @click="openConfirm(task.id)">
                🗑️ Delete
                </button>
            </div>
          </div>
          
        </li>
      </ul>
    </div>

    <!-- Modal de confirmation de suppression -->

    <div v-if="showConfirm" class="modal-overlay">
        <div class="modal">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this task?</p>
            <div class="modal-actions">
            <button class="cancel-btn" @click="showConfirm = false">Cancel</button>
            <button class="delete-btn" @click="confirmDelete">Delete</button>
            </div>
        </div>
        </div>


    <!-- Modal Ajouter Tâche -->
    <div v-if="showAddModal" class="modal-overlay">
      <div class="modal">
        <h2>Add New Task</h2>
        <form @submit.prevent="createTask">
          <input v-model="form.title" placeholder="Task Title" required />
          <textarea v-model="form.description" placeholder="Task Description"></textarea>
          
          <div class="modal-actions">
            <button type="submit" class="save-btn">Save</button>
            <button type="button" @click="closeModals" class="cancel-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Détails -->
    <div v-if="showDetailsModal" class="modal-overlay">
      <div class="modal">
        <h2>Task Details</h2>
        <p><strong>Title:</strong> {{ currentTask?.title }}</p>
        <p><strong>Description:</strong> {{ currentTask?.description }}</p>
        <p>
          <strong>Status:</strong>
          <span :class="currentTask?.done ? 'status-done' : 'status-pending'">
            {{ currentTask?.done ? '✅ Completed' : '⌛ Pending' }}
          </span>
        </p>
        <div class="modal-actions">
          <button class="cancel-btn" @click="closeModals">Close</button>
        </div>
      </div>
    </div>

    <!-- Modal Modifier -->
    <div v-if="showEditModal" class="modal-overlay">
      <div class="modal">
        <h2>Edit Task</h2>
        <form @submit.prevent="updateTaskFn">
          <input v-model="form.title" placeholder="Task Title" required />
          <textarea v-model="form.description" placeholder="Task Description"></textarea>
          <input type="checkbox" v-model="form.done" />
          <br /> <p style="text-align: center;"> Mark as done</p> 

            <div class="modal-actions">
            <button type="submit" class="save-btn">Update</button>
            <button type="button" @click="closeModals" class="cancel-btn">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>


import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useTaskStore } from '../stores/taskStore';

const router = useRouter();
const taskStore = useTaskStore();

// Vérifie si l'utilisateur est connecté
const isLoggedIn = computed(() => !!localStorage.getItem('token'));

// Fonctions des boutons
const goLogin = () => router.push({ path: '/' });
const goRegister = () => router.push({ path: '/register' });
const notif = () => router.push({ path: '/notifications' });
const logout = () => {
  localStorage.removeItem('token');
   if (localStorage.getItem('notifications')) {
    localStorage.removeItem('notifications');
  }
  router.push({ path: '/' });
  window.location.reload(); // met à jour l'affichage des boutons
};

// Modals
const showAddModal = ref(false);
const showDetailsModal = ref(false);
const showEditModal = ref(false);

//  Dropdown
const openMenuId = ref(null);

//Tâche courante
const currentTask = ref(null);

// Formulaire
const form = ref({ title: '', description: '', done: false });

// Récupération des tâches au montage
onMounted(() => {
  taskStore.fetchTasks();
});

//Dropdown
const toggleMenu = (id) => {
  openMenuId.value = openMenuId.value === id ? null : id;
};

// Ajouter Tâche
const openAddModal  = () => {
  form.value = { title: '', description: '', done: false };
  showAddModal.value = true;
};

// Détails
const openDetailsModal = (task) => {
  currentTask.value = task;
  showDetailsModal.value = true;
  openMenuId.value = null;
};

// Modifier
const openEditModal = (task) => {
  currentTask.value = task;
  form.value = { 
    id: task.id,       // ✅ important
    title: task.title,
    description: task.description,
    done: task.done
  };
  showEditModal.value = true;
  openMenuId.value = null;
};


//  Fermer Modals
const closeModals = () => {
  showAddModal.value = false;
  showDetailsModal.value = false;
  showEditModal.value = false;

  currentTask.value = null;
  form.value = { title: '', description: '', done: false, id: null };
};


// CRUD
const createTask = async () => {
  await taskStore.addTask(form.value);
  closeModals();
};

const updateTaskFn = async () => {
  try {
    if (!form.value.id) {
      console.error('Task ID missing!');
      return;
    }
    await taskStore.updateTask(form.value);
  } catch (err) {
    console.error('Update failed', err);
  } finally {
    closeModals(); 
  }
};

const deleteTask = async (id) => {
  await taskStore.deleteTask(id);
};
const showConfirm = ref(false);
const taskToDelete = ref(null);

const openConfirm = (id) => {
  taskToDelete.value = id;
  showConfirm.value = true;
};

const confirmDelete = async () => {
  await taskStore.deleteTask(taskToDelete.value);
  showConfirm.value = false;
  taskToDelete.value = null;
};

</script>
