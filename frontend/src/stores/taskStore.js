import { defineStore } from 'pinia'; // Store Pinia pour gérer les tâches et les notifications
import api from '../api/axios';
export const useTaskStore = defineStore('task', {
  state: () => ({
    tasks: [], // Liste des tâches
    notifications: [] // Liste des notifications
  }),
  actions: {
    // Récupère toutes les tâches depuis l'API
    async fetchTasks() {
      const { data } = await api.get('/tasks');
      this.tasks = data.data || []; // data.data contient le tableau des tâches
    },


    // Ajoute une nouvelle tâche via l'API
    async addTask(task) {
      const { data } = await api.post('/tasks', task);
      this.tasks.unshift(data.data); 
    },
    // Met à jour une tâche existante via l'API
    async updateTask(task) {
        const { data } = await api.put(`/tasks/${task.id}`, task);
        const index = this.tasks.findIndex(t => t.id === task.id);
        this.tasks[index] = data;
    }
    ,
    // Supprime une tâche via l'API
    async deleteTask(id) {
      await api.delete(`/tasks/${id}`);
      this.tasks = this.tasks.filter(t => t.id !== id);
    },
    // Ajoute une notification locale
    addNotification(msg) {
      this.notifications.push(msg);
    }
  }
});
