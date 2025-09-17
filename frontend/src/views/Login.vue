<template>
  <div class="login-container">
    <div class="login-card">
      <h1 class="title">Login</h1>
      <form @submit.prevent="handleLogin">
        <div class="input-group">
          <input type="email" v-model="email" placeholder="Email" required />
        </div>
        <div class="input-group">
          <input type="password" v-model="password" placeholder="Password" required />
        </div>
        <button type="submit" class="login-btn">Login</button>
      </form>
      <p class="register-text">
        Don't have an account?
        <router-link to="/register">Register</router-link>
      </p>
      <p v-if="error" class="error">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/authStore';

// Instance du router pour naviguer dans l'application
const router = useRouter();

// Access auth store
const authStore = useAuthStore();

// Accès au store d'authentification
const email = ref('');
const password = ref('');
const error = ref('');

// Fonction exécutée lors de la soumission du formulaire
const handleLogin = async () => {
  error.value = '';
  try {
    // Appelle la fonction login du store pour se connecter
    await authStore.login({ email: email.value, password: password.value });
    router.push('/tasks');
  } catch (e) {
    error.value = e.response?.data?.message || 'Login failed';
  }
};
</script>