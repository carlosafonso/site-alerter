<?php

declare(strict_types=1);

namespace App\Jobs;

interface Dispatchable
{
    public function serialize(): string;

    public static function fromSerialized(string $serialized): self;
}
