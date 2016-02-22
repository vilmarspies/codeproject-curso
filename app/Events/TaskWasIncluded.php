<?php

namespace CodeProject\Events;

use CodeProject\Entities\Project;
use CodeProject\Events\Event;
use CodeProject\Entities\ProjectTask;
use CodeProject\Services\ProjectService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class TaskWasIncluded extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $task;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProjectTask $task)
    {
        $this->task = $task;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['user.'.Authorizer::getResourceOwnerId()];
    }
}
