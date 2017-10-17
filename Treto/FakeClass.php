<?php
namespace Treto;

class FakeClass {
	public function __get($p) {
		return false;
	}

	public function __call($p, $q) {
		return false;
	}
}
?>