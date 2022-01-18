<?php

namespace Evo;

use App\Config;
use ErrorException;
use Exception;

class Error
{

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     * @throws ErrorException
     */
    public static function errorHandler(int $level, string $message, string $file, int $line)
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     */
    public static function exceptionHandler($exception)
    {
        // Code is 404 (not found) or 500 (general error)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            self::errorFancyDisplay($exception);
//            echo "<h1>Fatal error</h1>";
//            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
//            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
//            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
//            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {
            $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);

            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

            error_log($message);

            View::renderTemplate("$code.html");
        }
    }

    private static function errorFancyDisplay($exception)
    {
//        echo '<pre>';
//        print_r($exception);
//        echo '</pre>';
//        exit;

        $exception = [
            'message' => $exception->getMessage(),
            'class' => get_class($exception),
            'trace' => $exception->getTraceAsString(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'code' => $exception->getCode(),
        ];

//        echo '<pre>';
//        print_r($exception);
//        echo '</pre>';
//        exit;

        View::renderTemplate('error.html', $exception);
    }
}
