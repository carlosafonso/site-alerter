#!/usr/bin/env bash

echo "Creating SQS queue..."
awslocal sqs create-queue --queue-name sitealerter

echo "Listing queues..."
awslocal sqs list-queues
