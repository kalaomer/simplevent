<?php

namespace Simplevent;

/**
 * Event Emitter Interface
 *
 * @author Ömer Kala <kalaomer@hotmail.com>
 */

interface EventEmitterInterface {

    public function on($eventName, callable $callBack, $callbackObject = true);

    /**
     * Subscribe to an event exactly once.
     *
     * @param string $eventName
     * @param callable $callBack
     * @param int $priority
     * @return void
     */
    public function once($eventName, callable $callBack, $callbackObject = true);

    /**
     * Emits an event.
     *
     * @param string $eventName
     * @param array $arguments
     * @return bool
     */
    public function emit($eventName, array $arguments = array());


    /**
     * Returns the list of listeners for an event.
     *
     * @param string $eventName
     * @return array
     */
    public function listeners($eventName);

    /**
     * Removes a specific listener from an event.
     *
     * @param string $eventName
     * @param callable $listener
     * @return void
     */
    public function removeListener($eventName, $listener);

    /**
     * Removes all listeners from the specified event.
     *
     * @param string $eventName
     * @return void
     */
    public function removeAllListeners($eventName);
}
