import boto3
import hashlib
import json
import os
from repo import UrlRepository
import requests

sqs = boto3.client('sqs', endpoint_url=os.environ['SQS_ENDPOINT'])
ses = boto3.client('ses')
url_repo = UrlRepository(os.environ['URL_TABLE_NAME'], os.environ['DYNAMODB_ENDPOINT'])


class UrlCrawler(object):
    def __init__(self, url_repo):
        self.url_repo = url_repo

    def crawl_url(self, id):
        url = url_repo.find_url(id)

        if url is None:
            print("URL with ID {} does not exist".format(id))
        else:
            print("Checking URL '{}'".format(url['url']))
            r = requests.get(url['url'])
            current_hash = hashlib.sha256(r.text.encode(r.encoding)).hexdigest()

            if 'last_hash' not in url or url['last_hash'] != current_hash:
                print("New hash: '{}'".format(current_hash))
                url['last_hash'] = current_hash
                print("Updating URL in DB...")
                self.url_repo.update_url(url)
                print("Notifying via email...")
                source = "SiteAlerter Notifications <{}>".format(os.environ['NOTIFICATION_EMAIL_FROM'])
                ses.send_templated_email(
                    Source=source,
                    Destination={'ToAddresses': [os.environ['NOTIFICATION_EMAIL_TO']]},
                    Template=os.environ['SES_TEMPLATE_NAME'],
                    TemplateData=json.dumps({'url': url['url']})
                )
            else:
                print("Hashes match, no changes detected")


def crawler_handler(event, context):
    print("Payload has {} records".format(len(event['Records'])))
    crawler = UrlCrawler(url_repo)
    for record in event['Records']:
        body = json.loads(record['body'])
        crawler.crawl_url(body['pk'])


def scheduled_event_handler(event, context):
    urls = url_repo.get_urls()
    for url in urls:
        print("Enqueuing {}".format(url['url']))
        body = {'pk': url['pk']}
        sqs.send_message(
            QueueUrl=os.environ['CRAWLER_QUEUE_URL'],
            MessageBody=json.dumps(body)
        )
