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

    public function read()
    {
        $content = file_get_contents($this->config['path']);
        $content = (explode('@', preg_replace('#[\r\n]#', '@', $content)));

        $pattern = "/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<type>\w+):(?<number>.*):(?<message>.*)/m";
        $parentId = 0;
        $messages = collect();
        foreach ($content as $key => $value) {
            preg_match($pattern, $value, $matches);

            if (count($matches)) {
                $matches['id'] = $key;
                $messages->add($matches);
                $parentId = $key;
            } else {
                $messages = $messages->map(function ($message) use ($parentId, $value) {
                    if ($message['id'] !== $parentId) {
                        return $message;
                    }

                    return array_merge($message, ['message' => "{$message['message']} <br> {$value}"]);
                });
            }
        }

        return $messages->unique('number')->map(function ($data) use ($messages) {
            $sms = collect($messages)->where('number', $data['number'])->map(function ($message) {
                return [
                    'message' => trim($message['message']),
                    'date' => $message['date'],
                ];
            });
            
            return [
                'number' => trim($data['number']),
                'messages' => $sms,
                'lastMessage' => $sms->last(),
                'lastMessageDate' => $sms->last()['date'],
            ];
        })->sortByDesc('lastMessageDate')->values();
    }
}
