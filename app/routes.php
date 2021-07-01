<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;
use Webmozart\Assert\Assert;

return function (App $app): void {
    $container = $app->getContainer();
    Assert::notNull($container, '$container is null.');

    $app->options('/{routes:.*}', function (Request $request, Response $response): Response {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) use ($container): Response {
        return $container->get(Twig::class)->render($response, 'index.twig');
    });

    $app->group('/users', function (Group $group): void {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
