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

                // The AWS region to operate in.
                'app.aws.region' => $_ENV['AWS_REGION'],

                // The AWS endpoint.
                'app.aws.endpoint' => $_ENV['docker'] ? 'http://localstack:4566' : null,

                // The AWS credentials to use.
                //
                // In local environments set this to "false", which means "no
                // credentials". Otherwise specify "null", which will make the
                // AWS SDK to use the standard credential lookup chain.
                'app.aws.credentials' => $_ENV['docker'] ? false : null,

                // The URL of the SQS queue used to store job messages.
                'app.aws.sqsQueueUrl' => $_ENV['APP_SQS_QUEUE_URL'],
            ]);
        }
    ]);
};
