<?php

class Pokemon extends Eloquent {

	protected $table = 'pokemon'; # plural is same as singular, so must state table

	public function moves() {
		# Pokemon belongs to many moves
		return $this->belongsToMany('Move');
	}

	public function type() {
		# Pokemon belongs to many types
		return $this->belongsToMany('Type');
	}
}