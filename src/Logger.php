<?php

namespace log;

use Psr\Log\AbstractLogger;


class Logger extends AbstractLogger
{
    private function write($logDate, $logLevel, $message, array $context = []): void
    {
        $filePath = __DIR__. '/';
        $fileName = 'log.txt';
        $logInfo = $this->format($logDate, $logLevel, $message, $context);
        $logStr = implode(' ', $logInfo) . PHP_EOL;
        file_put_contents($filePath . $fileName,$logStr, FILE_APPEND );
    }

    private function format($logDate, $logLevel, $message, array $context = []): array
    {
        $logInfo = [];
        $logInfo['logDate'] = $logDate;
        $logInfo['logLevel'] = strtoupper($logLevel);
        $logInfo['logMessage'] = rtrim($message);
        $logInfo['context'] = serialize($context);
        return $logInfo;
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $logDate = date('Y-m-d H:i:s');
        try {
            $this->write($logDate, $level, $message, $context = []);
        } catch (\Exception $exception) {
            echo $exception ->getMessage();
        }
    }



}