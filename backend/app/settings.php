<?php
declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    // In AWS Lambda the only writeable directory is /tmp, thus
                    // we must ensure that logs are written to stdout to avoid
                    // errors. We check that we are running inside a Lambda
                    // function by checking the existence of the
                    // LAMBDA_TASK_ROOT env var.
                    'path' => isset($_ENV['docker']) || isset($_ENV['LAMBDA_TASK_ROOT']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
            ]);
        }
    ]);
};
