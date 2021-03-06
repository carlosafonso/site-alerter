import boto3
from boto3.dynamodb.conditions import Key
import datetime
import uuid


class UrlRepository(object):
    def __init__(self, table_name, endpoint_url):
        self.ddb = boto3.resource('dynamodb', endpoint_url=endpoint_url)
        self.url_table = self.ddb.Table(table_name)

    def get_urls(self):
        response = self.url_table.scan(
            Limit=20
        )
        # TODO: return LastEvaluatedKey for next pages, if any
        # TODO: filter by user ID
        return response['Items']

    def find_url(self, id):
        response = self.url_table.get_item(
            Key={
                'pk': id
            }
        )

        if 'Item' not in response:
            return None

        return response['Item']

    def create_url(self, url):
        item = {
            'pk': str(uuid.uuid4()),
            'url': url
        }
        self.url_table.put_item(
            Item=item
        )
        return item

    def update_url(self, url):
        response = self.url_table.update_item(
            Key={
                'pk': url['pk']
            },
            ConditionExpression=Key('pk').eq(url['pk']),
            UpdateExpression='SET last_hash = :last_hash, last_checked_at = :last_checked_at',
            ExpressionAttributeValues={
                ':last_hash': url['last_hash'],
                ':last_checked_at': datetime.datetime.utcnow().isoformat()
            },
            ReturnValues='ALL_NEW'
        )
        return response['Attributes']

    def delete_url(self, id):
        return self.url_table.delete_item(
            Key={
                'pk': id
            }
        )
