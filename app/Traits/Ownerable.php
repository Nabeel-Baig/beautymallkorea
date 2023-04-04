<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait Ownerable {
	final public function owns(Model $model, string $ownerReferencingAttribute): bool {
		return $this->getKey() === $model->$ownerReferencingAttribute;
	}

	final public function doesNotOwn(Model $model, string $ownerReferencingAttribute): bool {
		return !$this->owns($model, $ownerReferencingAttribute);
	}
}
