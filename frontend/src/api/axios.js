import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost:8000/api', // URL de base pour toutes les requêtes
});

api.interceptors.request.use(config => {
    const token = localStorage.getItem('token'); // Récupère le token depuis le stockage local
    if (token) {
        config.headers.Authorization = `Bearer ${token}`; // Ajoute le token aux en-têtes
    }
    return config;
});

export default api; // Export de l'instance Axios pour l'utiliser dans toute l'application
