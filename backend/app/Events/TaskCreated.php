<?php
namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $task; // La tâche qui vient d'être créée

    public function __construct(Task $task)
    {
        $this->task = $task;  // On garde la tâche pour l’envoyer au front
    }

    public function broadcastOn()
    {
        return new Channel('tasks'); // Canal public où on envoie l’événement
    }

    public function broadcastWith()
    {
        return [
            'id'    => $this->task->id,
            'title' => $this->task->title,
        ]; // Les infos qu’on envoie au front
    }
    public function broadcastAs()
    {
        return 'TaskCreated'; // Nom de l’événement
    }
}
