<?php
namespace WindowsAzure\TaskDemoBundle\Entity;

use Doctrine\KeyValueStore\Mapping\Annotations as KeyValue;

/**
 * @KeyValueStore\Entity(storageName="messages")
 */
class Message
{
    /** @KeyValue\Id */
    private $user;
    /** @KeyValue\Id */
    private $message;

    public function __construct($user, $message)
    {
        $this->user    = $user;
        $this->message = $message;
    }

    /**
     * Get user.
     *
     * @return user.
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get message.
     *
     * @return message.
     */
    public function getMessage()
    {
        return $this->message;
    }
}

