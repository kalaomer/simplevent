<?php

namespace Simplevent;

use Ider;

trait EventEmitterTrait {

	protected $listeners =  array();

	Public function on( $eventName, callable $callback, $closureObject = true )
	{

		// If $callback is Closure, bind Closure with $closureObject
		if ( $callback instanceof \Closure )
		{
			if ( $closureObject == true ) {
				$closureObject = $this;
			}
			
			if ( is_object( $closureObject ) ) {
				$callback = $callback->bindTo( $closureObject, $closureObject );
			}
		}
		
		$listenerID = Ider::getID( $callback );

		$this->listeners($eventName)[ $listenerID ] = $callback;

		return $listenerID;
	}

	Public function once( $eventName, callable $callback, $closureObject = true )
	{

		// If $callback is Closure, bind Closure with $closureObject
		if ( $callback instanceof \Closure )
		{
			if ( $closureObject == true ) {
				$closureObject = $this;
			}
			
			if ( is_object( $closureObject ) ) {
				$callback = $callback->bindTo( $closureObject, $closureObject );
			}
		}

		$listenerID = Ider::getID( $callback );

		$remover = null;
		$remover = function() use ( $eventName, $callback, &$remover ) {

			$removerID = Ider::getID( $remover );

			$this->removeListener( $eventName, $removerID );
			$this->removeListener( $eventName, $callback );

			return call_user_func( $callback, func_get_args() );

		};

		return $this->on( $eventName, $remover, false );
	}

	Public function emit( $eventName, array $arguments = array() )
	{
		foreach ($this->listeners( $eventName ) as $key => $callback) {
			$retult = call_user_func_array($callback, $arguments);

			if ($retult === false)
			{
				return false;
			}
		}

		return true;
	}

	Public function removeListener( $eventName, $listenerID )
	{
		if ( is_callable( $listenerID ) )
		{
			$listenerID = Ider::getID( $listenerID );
		}

		$listeners = &$this->listeners( $eventName );

		if ( isset( $listeners[ $listenerID ] ) )
		{
			unset( $listeners[ $listenerID ] );

			return true;
		}

		return false;
	}

	Public function removeAllListeners( $eventName )
	{
		$listeners =& $this->listeners( $eventName );
		$listeners = [];
	}

	Public function &listeners( $eventName )
	{
		if (! isset($this->listeners[ $eventName ]) ) {
			$this->listeners[ $eventName ] = [];
		}

		return $this->listeners[ $eventName ];
	}

}