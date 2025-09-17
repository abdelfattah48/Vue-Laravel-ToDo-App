import { defineStore } from 'pinia'; // Store Pinia pour la gestion de l'authentification utilisateur
import api from '../api/axios';// Instance Axios pour les appels API

export const useAuthStore = defineStore('auth', {
    // données réactives du store
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || null,
    }),
    actions: {
        async login(credentials) {
            const { data } = await api.post('/auth/login', credentials); //Envoie les informations de connexion à l'API
            this.token = data.token; 
            localStorage.setItem('token', data.token);// Stocke le token dans le state et localStorage 
            await this.fetchUser();//Récupère les informations de l'utilisateur connecté
        },
        async register(userData) {
            await api.post('/auth/register', userData); // Envoie les informations à l'API pour créer le compte
        },
         
        // Récupère les informations de l'utilisateur connecté
        async fetchUser() {
            const { data } = await api.get('/auth/me');
            this.user = data;
        },
        
        // Déconnexion de l'utilisateur
        logout() {
            this.user = null;
            this.token = null;
            localStorage.removeItem('token');
        }
    }
});
