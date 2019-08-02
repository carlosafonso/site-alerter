# carlosafonso/site-alerter

(This is a WIP project.)

The aim of this project is to develop a serverless tool that alerts users when contents of a site change. This is useful to track changes to relatively static websites without having to manually check them.

## Architecture

![Architecture diagram](arch-diagram.png)

## Deploying the app

Use the included CloudFormation template and deploy it either with the AWS Management Console or the CLI. For the latter:

```
aws cloudformation create-stack --stack-name '<your stack name>' \
	--template-body file://./template.yaml \
	--parameters \
		ParameterKey=Env,ParameterValue=<your environment name> \
		ParameterKey=VPCName,ParameterValue=<your VPC name>
```

## Local development

```
# Start DynamoDB Local (this command works if DDB Local was installed via Brew)
dynamodb-local -sharedDb

# Create the Urls table
aws --endpoint-url=http://localhost:8000 \
	dynamodb create-table --cli-input-json file://./util/urls_table_definition.json

# Start the API
sam local start-api -n env.dev.json
```
