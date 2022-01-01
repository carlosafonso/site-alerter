<?php
declare(strict_types=1);

use App\Application\Actions\Site\CreateSiteAction;
use App\Application\Actions\Site\DeleteSiteAction;
use App\Application\Actions\Site\ListSitesAction;
use App\Application\Actions\Site\UpdateSiteAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/sites', function (Group $group) {
        $group->get('', ListSitesAction::class);
        $group->post('', CreateSiteAction::class);
        $group->put('/{id}', UpdateSiteAction::class);
        $group->delete('/{id}', DeleteSiteAction::class);
    });
};
