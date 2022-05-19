<?php
/**
 * Файл Logger.php
 * @package lana/logger
 * @author Lana Vlasenko <lanachka1993@gmail.com>
 */
namespace logger;

use Psr\Log\AbstractLogger;

/**
 * Основной класс логгера.
 * Pеализует интерфейс PSR LoggerInterface. Умеет форматировать и записывать логи в файл.
 */
class Logger extends AbstractLogger
{
    /**
     * Метод write сохраняет предварительно отформатированные записи в файл.
     * @param $logDate
     * @param $logLevel
     * @param $message
     * @param array $context
     * @return void
     */
    private function write($logDate, $logLevel, $message, array $context = array())
    {
        $filePath = __DIR__. '/';
        $fileName = 'log.txt';
        $logInfo = $this->format($logDate, $logLevel, $message, $context);
        $logStr = implode(' ', $logInfo) . PHP_EOL;
        file_put_contents($filePath . $fileName,$logStr, FILE_APPEND );
    }

    /**
     * Метод format форматирует запись, так как один из параметров массив
     * @param $logDate
     * @param $logLevel
     * @param $message
     * @param array $context
     * @return array
     */
    private function format($logDate, $logLevel, $message, array $context = array())
    {
        $logInfo = [];
        $logInfo['logDate'] = $logDate;
        $logInfo['logLevel'] = strtoupper($logLevel);
        $logInfo['logMessage'] = rtrim($message);
        $logInfo['context'] = serialize($context);
        return $logInfo;
    }

    /**
     * формат записи в файл
     * @param $level
     * @param $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $logDate = date('Y-m-d H:i:s');
        try {
            $this->write($logDate, $level, $message, $context);
        } catch (\Exception $exception) {
            echo $exception ->getMessage();
        }
    }
}        
