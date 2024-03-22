<?php

namespace Khelechy\Argus\Handlers;

define('ARGUSEVENTNAME', 'argus.event.received', false);

class EventBus{

    const ARGUSEVENTNAME = 'argus.event.received';

    private $subscribers = [];

    public function subscribe($subscriber, string $methodName) {
        $this->subscribers[constant('ARGUSEVENTNAME')][] = [$subscriber, $methodName];
    }

    public function publish($data = null) {
        if (isset($this->subscribers[constant('ARGUSEVENTNAME')])) {
            foreach ($this->subscribers[constant('ARGUSEVENTNAME')] as [$subscriber, $methodName]) {
                $subscriber->$methodName($data);
            }
        }
    }
}