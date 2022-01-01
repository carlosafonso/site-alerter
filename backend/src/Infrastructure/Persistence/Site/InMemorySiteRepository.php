<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Site;

use App\Domain\Site\Site;
use App\Domain\Site\SiteNotFoundException;
use App\Domain\Site\SiteRepository;

class InMemorySiteRepository implements SiteRepository
{
    /**
     * @var Site[]
     */
    private $sites;

    public function __construct(array $sites = null)
    {
        $this->sites = $sites ?? [
            'e558e16d-4569-4846-bbbe-b51e8d57a00d' => new Site('e558e16d-4569-4846-bbbe-b51e8d57a00d', 'https://www.google.com'),
            'aed9e8cc-0e7d-4095-9ba9-a26edb42e9a8' => new Site('aed9e8cc-0e7d-4095-9ba9-a26edb42e9a8', 'https://www.microsoft.com'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->sites);
    }

    /**
     * {@inheritdoc}
     */
    public function findById(string $id): Site
    {
        if (!isset($this->sites[$id])) {
            throw new SiteNotFoundException();
        }

        return $this->sites[$id];
    }

    /**
     * {@inheritDoc}
     */
    public function store(Site $site): Site
    {
        return $site;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Site $site): void
    {
        //
    }
}
