<?php

declare(strict_types=1);

namespace App\Domain\Site;

use App\Domain\DomainException\DomainRecordNotFoundException;

class SiteNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The site you requested does not exist.';
}
