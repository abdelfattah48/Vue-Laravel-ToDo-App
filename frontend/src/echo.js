import Echo from "laravel-echo";
import Pusher from "pusher-js";
// Configuration de Laravel Echo pour écouter les événements en temps réel

window.Pusher = Pusher;// Définir Pusher dans la fenêtre globale pour Laravel Echo

// Initialisation d'Echo avec Pusher
const echo = new Echo({
  broadcaster: "pusher",// Type de diffusion 
  key: "89d3bf40dbb59d7ce720", // Clé publique Pusher
  cluster: "mt1", 
  forceTLS: true,
});

export default echo;  // Export pour être utilisé dans les composants Vue
