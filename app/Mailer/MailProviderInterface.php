<?php

namespace App\Mailer;

use App\DataTransfers\DataTransferObjects\MailMessageTransfer;

interface MailProviderInterface
{
    public function send(MailMessageTransfer $mailMessageTransfer): bool;
}
