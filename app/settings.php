<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder): void {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function (): Settings {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'torbin',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'twig' => [
                    'debug' => false,
                    'charset' => 'UTF-8',
                    'strict_variables' => false,
                    'autoescape' => 'html',
                    'cache' => false,
                    'auto_reload' => null,
                    'optimizations' => -1,
                ]
            ]);
        }
    ]);
};
