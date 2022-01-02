<?php

declare(strict_types=1);

namespace App\Jobs;

use Aws\Sqs\SqsClient;

class JobDispatcher
{
    public function __construct(
        protected SqsClient $sqs,
        protected string $queueUrl
    ) {}

    public function dispatch(Dispatchable $job)
    {
        $this->sqs->sendMessage([
            'MessageBody' => $job->serialize(),
            'QueueUrl' => $this->queueUrl,
        ]);
    }
}
