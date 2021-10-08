<?php

declare(strict_types=1);

final class Log
{
    public const LOG_FILE = 'app.log';
    public const LOG_DIR = __DIR__ . '/../../var/log/';

    public const EMERG  = 0;  // Emergency: system is unusable
    public const ALERT  = 1;  // Alert: action must be taken immediately
    public const CRIT   = 2;  // Critical: critical conditions
    public const ERR    = 3;  // Error: error conditions
    public const WARN   = 4;  // Warning: warning conditions
    public const NOTICE = 5;  // Notice: normal but significant condition
    public const INFO   = 6;  // Informational: informational messages
    public const DEBUG  = 7;  // Debug: debug messages

    /**
     * Log data
     *
     * @param mixed       $message
     * @param int         $level
     * @param string|null $logFile
     *
     * @return int
     */
    public static function add($message, int $level = self::INFO, ?string $logFile = null): int
    {
        if ($message instanceof Throwable) {
            $message = $message->getMessage() . "\n" . $message->getTraceAsString();
        }
        if (is_array($message) || is_object($message)) {
            $message = print_r($message, true);
        }
        $message = addcslashes((string) $message, '<?');
        $message = self::getPrefix($level) . $message . "\n";

        if (!$logFile) {
            $logFile = self::LOG_FILE;
        }

        return (int) file_put_contents(self::LOG_DIR . $logFile, $message, FILE_APPEND);
    }

    /**
     * Retrieve message prefix
     *
     * @param int $level
     *
     * @return string
     */
    protected static function getPrefix(int $level): string
    {
        $data = [
            date('Y-m-d H:i:s'),
            str_pad(strtoupper(self::getLevelLabel($level)), 10),
            ''
        ];

        return join(' | ', $data);
    }

    /**
     * Retrieve level label
     *
     * @param int $level
     *
     * @return string
     */
    public static function getLevelLabel(int $level): string
    {
        $levels = self::getLevels();

        return $levels[$level] ?? '';
    }

    /**
     * Retrieve levels
     *
     * @return string[]
     */
    public static function getLevels(): array
    {
        return [
            self::EMERG  => 'Emergency',
            self::ALERT  => 'Alert',
            self::CRIT   => 'Critical',
            self::ERR    => 'Error',
            self::WARN   => 'Warning',
            self::NOTICE => 'Notice',
            self::INFO   => 'Info',
            self::DEBUG  => 'Debug',
        ];
    }
}
