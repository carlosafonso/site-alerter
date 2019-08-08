import hashlib
import os
from repo import UrlRepository
import requests

url_repo = UrlRepository(os.environ['URL_TABLE_NAME'], os.environ['DYNAMODB_ENDPOINT'])


class UrlCrawler(object):
    def __init__(self, url_repo):
        self.url_repo = url_repo

    def crawl_urls(self):
        urls = url_repo.get_urls()
        for url in urls:
            print("Checking URL '{}'".format(url['url']))
            r = requests.get(url['url'])
            current_hash = hashlib.sha256(r.text.encode(r.encoding)).hexdigest()

            if 'last_hash' not in url or url['last_hash'] != current_hash:
                print("New hash: '{}'".format(current_hash))
                url['last_hash'] = current_hash
                self.url_repo.update_url(url)
            else:
                print("Hashes match, no changes detected")


def lambda_handler(event, context):
    crawler = UrlCrawler(url_repo)
    crawler.crawl_urls()
