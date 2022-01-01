<?php

declare(strict_types=1);

namespace App\Domain\Site;

interface SiteRepository
{
    /**
     * @return Site[]
     */
    public function findAll(): array;

    public function findById(string $id): Site;

    public function store(Site $site): Site;

    public function delete(Site $site): void;
}
