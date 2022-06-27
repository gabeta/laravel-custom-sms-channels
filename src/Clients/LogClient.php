<?php


namespace Gabeta\CustomSmsChannels\Clients;

use Illuminate\Log\LogManager;

class LogClient
{
    protected $logger;

    public function __construct(LogManager $logger, array $config)
    {
        $this->logger = $logger->build($config);
    }

    public function write(string $message)
    {
        $this->logger->info($message);
    }
}
