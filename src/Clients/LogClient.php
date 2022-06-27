<?php


namespace Gabeta\CustomSmsChannels\Clients;

use Illuminate\Log\LogManager;

class LogClient
{
    protected $logger;
    protected $config;

    public function __construct(LogManager $logger, array $config)
    {
        $this->logger = $logger->build($config);
        $this->config = $config;
    }

    public function write(string $message)
    {
        $this->logger->info($message);
    }

    public function readContent()
    {
        $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<number>.*):(?<message>.*)/m";
        $content = file_get_contents($this->config['path']);
        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER, 0);

        return collect($matches)->unique('number')->map(function ($data) use ($matches) {
            $messages = collect($matches)->where('number', $data['number'])->map(function ($message) {
                return [
                    'message' => trim($message['message']),
                    'date' => $message['date']
                ];
            });

            return [
                'number' => trim($data['number']),
                'messages' => $messages,
                'lastMessage' => $messages->last()
            ];
        });
    }
}
