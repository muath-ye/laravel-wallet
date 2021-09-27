<?php

namespace Muathye\Wallet\Exceptions;

use Exception;

class WalletException extends Exception
{
    /**
     * The attributes that handle the exception errors.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * The attribute that handle the exception message
     *
     * @var string
     */
    protected $message = 'The given data was invalid.';

    /**
     * The attribute that handle the exception status
     * 410 [gone], 418 [I'm a teapot]
     *
     * @var int
     */
    protected $status = 418;

    /**
     * Create a new ApiException instance.
     *
     * @param  array  $errors
     * @param  string  $message
     * @return void
     */
    public function __construct($errors, $message = null, $status = null)
    {
        $this->errors = $errors;
        $this->message = is_null($message) ? $this->message : $message;
        $this->status = is_null($status) ? $this->status : $status;
    }

    /**
     * By defining a context method on one of your application's
     * custom exceptions, you may specify any data relevant to that
     * exception that should be added to the exception's log entry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Request
     */
    public function context()
    {
        return [$this->message, $this->errors, $this->status];
    }
    
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function render($request)
    // {
    //     return [$this->message, $this->errors, $this->status];
    // }
}
