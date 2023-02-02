<?php

function create( $class, $times = null, $attributes = [] ) {
	return factory( $class, $times )->create($attributes);
}

function make( $class, $times = null, $attributes = [] ) {
	return factory( $class, $times )->make($attributes);
}