<?php

declare(strict_types=1);

namespace App\Domain\Site;

use JsonSerializable;

class Site implements JsonSerializable
{
    public function __construct(
        protected ?string $id,
        protected string $url
    ) {}

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
        ];
    }
}
