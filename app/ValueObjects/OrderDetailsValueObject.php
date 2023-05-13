<?php

namespace App\ValueObjects;

use App\Extensions\ValueObjectExtensions;
use JsonSerializable;

class OrderDetailsValueObject implements JsonSerializable {
	use ValueObjectExtensions;

	private string $ipAddress;
	private string $userAgent;
	private string $comment;

	final public function getIpAddress(): string {
		return $this->ipAddress;
	}

	final public function setIpAddress(string $ipAddress): void {
		$this->ipAddress = $ipAddress;
	}

	final public function getUserAgent(): string {
		return $this->userAgent;
	}

	final public function setUserAgent(string $userAgent): void {
		$this->userAgent = $userAgent;
	}

	final public function getComment(): string {
		return $this->comment;
	}

	final public function setComment(string $comment): void {
		$this->comment = $comment;
	}

	final public function jsonSerialize(): array {
		return [
			"ipAddress" => $this->ipAddress,
			"userAgent" => $this->userAgent,
			"comment" => $this->comment,
		];
	}
}
