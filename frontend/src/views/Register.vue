<template>
  <div class="register-container">
    <div class="register-card">
      <h1 class="title">Register</h1>
    <!-- Formulaire d'inscription -->
      <form @submit.prevent="handleRegister">
        <div class="input-group">
          <input type="text" v-model="full_name" placeholder="Full Name" required />
        </div>
        <div class="input-group">
          <input type="email" v-model="email" placeholder="Email" required />
        </div>
        <div class="input-group">
          <input type="text" v-model="phone" placeholder="Phone" />
        </div>
        <div class="input-group">
          <input type="text" v-model="address" placeholder="Address" />
        </div>
        <div class="input-group">
          <input type="password" v-model="password" placeholder="Password" required />
        </div>
        <div class="input-group">
          <input type="file" @change="handleFileChange" accept="image/*" />
          <p v-if="fileName" class="file-name">{{ fileName }}</p>
        </div>

        <button type="submit" class="register-btn">Register</button>
      </form>

      <p class="login-text">
        Already have an account?
        <router-link to="/">Login</router-link>
      </p>

      <p v-if="error" class="error">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/authStore';

const router = useRouter();
const authStore = useAuthStore();

// Champs du formulaire
const full_name = ref('');
const email = ref('');
const phone = ref('');
const address = ref('');
const password = ref('');
const error = ref('');

// Gestion du fichier sélectionné
const selectedFile = ref(null);
const fileName = ref('');

//  appelée quand un fichier est choisi
const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    selectedFile.value = file;
    fileName.value = file.name;
  }
};

// appelée à la soumission du formulaire
const handleRegister = async () => {
  error.value = '';

  try {
    // Création d'un FormData pour envoyer le fichier et les autres champs
    const formData = new FormData();
    formData.append('full_name', full_name.value);
    formData.append('email', email.value);
    formData.append('phone', phone.value);
    formData.append('address', address.value);
    formData.append('password', password.value);
    if (selectedFile.value) {
      formData.append('image', selectedFile.value); 
    }
    // Appelle la fonction register du store
    await authStore.register(formData);
     // Redirection vers la page de connexion
    router.push('/');
  } catch (e) {
    error.value = e.response?.data?.message || 'Registration failed';
  }
};
</script>
