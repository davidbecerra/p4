<?php

class Type extends Eloquent {
	
	# Enable fillable on the 'name' column so we can use the Model shortcut Create
	protected $fillable = array('name');

	public function pokemon() {
		# Type belongs to many Pokemon
		return $this->belongsToMany('Pokemon');
	}

	public function moves() {
		# Type has many moves
		return $this->hasMany('Move');
	}
}