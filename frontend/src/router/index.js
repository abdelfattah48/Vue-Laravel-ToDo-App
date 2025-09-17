import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios'; // Utilisé pour la vérification optionnelle du token côté backend

// Import des composants de pages
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Tasks from '../views/Tasks.vue';
import Notifications from '../views/Notifications.vue';

// Définition des routes de l'application
const routes = [
  { path: '/', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  { path: '/tasks', name: 'Tasks', component: Tasks, meta: { requiresAuth: true } },
  { path: '/notifications', name: 'Notifications', component: Notifications, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Route guard pour Vérifie si l'utilisateur peut accéder aux routes protégées
router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('token'); // Récupère le token depuis le stockage local

  // Si la route nécessite une authentification
  if (to.meta.requiresAuth) {
    if (!token) {
      // Pas de token -> redirection vers la page de connexion
      return next({ path: '/' });
    }
    //  Vérification du token côté backend    
    try {
      await axios.get('/api/auth/me', {
        headers: { Authorization: `Bearer ${token}` }
      });
      return next(); // Token valide → accès autorisé
    } catch (err) {
      localStorage.removeItem('token');// Token invalide → suppression et redirection vers la page de connexion
      return next({ path: '/' });
    }

    return next();
  }
  return next();
});

export default router;
