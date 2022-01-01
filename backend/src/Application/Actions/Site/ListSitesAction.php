<?php

declare(strict_types=1);

namespace App\Application\Actions\Site;

use Psr\Http\Message\ResponseInterface as Response;

class ListSitesAction extends SiteAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $sites = $this->siteRepository->findAll();

        $this->logger->info("Sites list was viewed.");

        return $this->respondWithData($sites);
    }
}
