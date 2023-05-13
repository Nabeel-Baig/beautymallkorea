<?php

namespace App\ValueObjects;

use App\Extensions\ValueObjectExtensions;
use JsonSerializable;

class ProductMetaValueObject implements JsonSerializable {
	use ValueObjectExtensions;

	private string $metaTitle;
	private string $metaKeywords;
	private string $metaDescription;

	final public function getMetaTitle(): string {
		return $this->metaTitle;
	}

	final public function setMetaTitle(string $metaTitle): void {
		$this->metaTitle = $metaTitle;
	}

	final public function getMetaKeywords(): string {
		return $this->metaKeywords;
	}

	final public function setMetaKeywords(string $metaKeywords): void {
		$this->metaKeywords = $metaKeywords;
	}

	final public function getMetaDescription(): string {
		return $this->metaDescription;
	}

	final public function setMetaDescription(string $metaDescription): void {
		$this->metaDescription = $metaDescription;
	}


	final public function jsonSerialize(): array {
		return [
			"metaTitle" => $this->metaTitle,
			"metaKeywords" => $this->metaKeywords,
			"metaDescription" => $this->metaDescription,
		];
	}
}
