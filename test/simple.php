<?php

require '../vendor/autoload.php';

class Simple extends Simplevent\EventEmitter {
	Public $name = "Simple Class";
}

$simple = new Simple;

$nameID = $simple->on( "name", function() { var_dump($this->name); } );

$clauseID = $simple->once( "name", function() { var_dump("I just said my name"); } );

var_dump($simple->listeners("name"));

$simple->emit( "name" );

$simple->emit( "name" );

// $simple->removeListener( "name", $nameID );

$simple->emit( "name" );