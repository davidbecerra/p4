<?php

class Pokemon extends Eloquent {

	protected $table = 'pokemon'; # plural is same as singular, so must state table

	public function abilities() {
		# Pokemon belongs to many abilities
		return $this->belongsToMany('Ability');
	}

	public function moves() {
		# Pokemon belongs to many moves
		return $this->belongsToMany('Move')->withPivot('level');
	}

	public function types() {
		# Pokemon belongs to many types
		return $this->belongsToMany('Type');
	}
}