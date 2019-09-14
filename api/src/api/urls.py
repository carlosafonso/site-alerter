import json
import os
from repo import UrlRepository

url_repo = UrlRepository(os.environ['URL_TABLE_NAME'], os.environ['DYNAMODB_ENDPOINT'])


def get_urls():
    return {'items': url_repo.get_urls()}


def create_url(body):
    # TODO: validate payload
    return url_repo.create_url(body['url'])


def delete_url(id):
    url = url_repo.find_url(id)
    # TODO: check for existence and correct ownership
    url_repo.delete_url(url['pk'])


def lambda_handler(event, context):
    if event['httpMethod'] == 'GET':
        response = get_urls()
        status_code = 200
    elif event['httpMethod'] == 'POST':
        response = create_url(json.loads(event['body']))
        status_code = 201
    elif event['httpMethod'] == 'DELETE':
        response = delete_url(event['pathParameters']['id'])
        status_code = 204
    else:
        return {'statusCode': 405, 'body': 'Unsupported method'}

    return {
        'statusCode': status_code,
        'headers': {
            'Content-Type': 'application/json',
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': 'Content-Type'
        },
        'body': json.dumps(response),
    }
