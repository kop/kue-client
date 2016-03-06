<?php

namespace kop\kue\exceptions;

/**
 * Class `ApiException`
 * ====================
 *
 * This class represents an exception caused by API request made by the user.
 *
 *
 * @link    https://kop.github.io/php-kue-client/ Project page.
 * @license https://github.com/kop/php-kue-client/blob/master/LICENSE.md MIT
 *
 * @author  Ivan Koptiev <ivan.koptiev@codex.systems>
 */
class ApiException extends Exception
{
    /**
     * @var integer HTTP status code, such as 403, 404, 500, etc.
     */
    public $statusCode;

    /**
     * Class constructor.
     *
     * @param integer $status HTTP status code, such as 404, 500, etc.
     * @param string $message Error message.
     * @param integer $code Error code.
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($status, $message = null, $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $status;
        parent::__construct($message, $code, $previous);
    }
}