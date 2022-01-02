<?php

declare(strict_types=1);

namespace App\Jobs;

class CrawlSiteJob implements Dispatchable
{
    public function __construct(public string $siteId) {}

    /**
     * {@inheritDoc}
     */
    public function serialize(): string
    {
        return json_encode(['site_id' => $this->siteId]);
    }

    /**
     * {@inheritDoc}
     */
    public static function fromSerialized(string $serialized): self
    {
        $deserialized = json_decode($serialized);
        return new static($deserialized->site_id);
    }
}
