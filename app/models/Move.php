<?php

class Move extends Eloquent {

	public function pokemon() {
		# Move belongs to many Pokemon
		return $this->belongsToMany('Pokemon');
	}
	
	public function type() {
		# Move belongs to Type
		return $this->belongsTo('Type');
	}
}