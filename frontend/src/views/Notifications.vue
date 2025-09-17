<template>
  <div>
    <div class="auth-buttons">
      <button v-if="!isLoggedIn" @click="goLogin">Login</button>
      <button v-if="!isLoggedIn" @click="goRegister">Register</button>
      <button v-else @click="logout">Logout</button>
      <button 
  @click="Home" 
  style="
    background-color: #1c1f1cff; 
    color: white; 
    padding: 10px 20px; 
    border: none; 
    border-radius: 8px; 
    font-weight: bold; 
    cursor: pointer;
    transition: 0.3s;
  "
>
  Home
</button>
    </div>

    <div class="container">
      <h1>Notifications</h1>
      <ul>
        <li v-for="(msg, index) in messages" :key="index">
          {{ msg }}
        </li>
      </ul>
    </div>
  </div>
  
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import echo from "../echo";

const router = useRouter();

//  Vérifie si l'utilisateur est connecté
const isLoggedIn = computed(() => !!localStorage.getItem('token'));

// Fonctions des boutons d'authentification
const goLogin = () => router.push({ path: '/' });
const goRegister = () => router.push({ path: '/register' });
const Home = () =>router.push('/tasks');

const logout = () => {
  localStorage.removeItem('token');  // Supprime le token
  localStorage.removeItem('notifications');  // Supprime les notifications
  messages.value = [];  // Réinitialise le tableau de notifications
  router.push({ path: '/' }); // Redirection vers la page de login
};

// Notifications
const messages = ref([]);

// Charger les notifications depuis localStorage et écouter les événements en temps réel
onMounted(() => {
  // Charger les notifications sauvegardées
  const stored = localStorage.getItem('notifications');
  if (stored) {
    messages.value = JSON.parse(stored);
  }

 // Écoute des événements TaskCreated via Laravel Echo
 echo.channel("tasks")
    .listen(".TaskCreated", (event) => {
      console.log("Event received in Vue:", event);
      const msg = `Task "${event.title}" created successfully!`;
      messages.value.unshift(msg);// Ajoute la nouvelle notification en début de liste

      // Sauvegarde les notifications dans localStorage
      localStorage.setItem('notifications', JSON.stringify(messages.value));
    });
});
</script>

