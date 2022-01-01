<?php

declare(strict_types=1);

namespace App\Application\Actions\Site;

use App\Domain\Site\Site;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteSiteAction extends SiteAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $site = $this->siteRepository->findById($this->resolveArg('id'));
        $this->siteRepository->delete($site);
        return $this->respondWithData(null, 204);
    }
}
