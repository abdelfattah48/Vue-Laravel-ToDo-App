import { createApp } from 'vue';
import { createPinia } from 'pinia';// Pour la gestion d'état globale
import router from './router';  // Router pour la navigation entre pages
import App from './App.vue'; // Composant racine
import './style.css'; // Styles globaux
import echo from './echo';   // Laravel Echo pour les notifications en temps réel

// Création de l'application Vue
const app = createApp(App);

// Ajout du store Pinia à l'application
app.use(createPinia());

// Ajout du router pour gérer les routes
app.use(router);
app.mount('#app');
