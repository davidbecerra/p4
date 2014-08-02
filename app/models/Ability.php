<?php 

class Ability extends Eloquent {

	# Enable fillable on all columns so we can use the Model create shortcut
	protected $fillable = array('name', 'effect');

	public function pokemon() {
		# Ability belongs to many Pokemon
		return $this->belongsToMany('Pokemon');
	}
}