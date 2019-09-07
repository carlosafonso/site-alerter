#!/bin/bash

set -euxo pipefail

aws cloudformation deploy \
	--template-file ./template.yaml \
	--stack-name "$1" \
	--parameter-overrides "Env=dev" \
	--capabilities=CAPABILITY_IAM
