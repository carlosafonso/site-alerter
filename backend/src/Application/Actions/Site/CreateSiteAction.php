<?php

declare(strict_types=1);

namespace App\Application\Actions\Site;

use App\Domain\Site\Site;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Request;

class CreateSiteAction extends SiteAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $data = $this->getFormData();

        $site = new Site(null, $data->url);
        $this->siteRepository->store($site);

        return $this->respondWithData($site, 200);
    }
}
