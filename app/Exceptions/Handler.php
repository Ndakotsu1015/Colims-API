<?php

namespace App\Exceptions;

use App\Traits\JsonResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use JsonResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        /*
         * We add a custom exception renderer here since this will be an api only backend.
         * So we need to convert every exception to a json response.
         */
        Log::error('[Handler] [render] '.$exception->getMessage());
        Log::error('[Handler] [render] '.$exception->getTraceAsString());
        return $this->getJsonResponse($exception);
    }

    /**
     * Get the json response for the exception.
     *
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponse(Throwable $exception)
    {
        $debugEnabled = config('app.debug');

        $exception = $this->prepareException($exception);

        /*
         * Handle validation errors thrown using ValidationException.
         */
        if ($exception instanceof ValidationException) {

            Log::error("ValidationException: ".$exception->validator->errors());
            Log::error("ValidationException: ".$exception->getMessage());
            Log::error("ValidationException: ".$exception->getTraceAsString());

            $validationErrors = $exception->validator->errors()->all();

            return $this->error($validationErrors, 400);
        }

        /*
         * Handle database errors thrown using QueryException.
         * Prevent sensitive information from leaking in the error message.
         */
        if ($exception instanceof QueryException) {
            if ($debugEnabled) {
                $message = $exception->getMessage();
            } else {
                $message = 'Database error.';
            }
        }


        /*
         * Handle model not found  thrown using NotFoundHttpException.
         */
        if ($exception instanceof NotFoundHttpException) {
            Log::error("[Handler] [render] NotFoundHttpException: ".$exception->getMessage());
            Log::error("[Handler] [render] NotFoundHttpException: ".$exception->getTraceAsString());

            $message = "Resource not found.";
            return $this->error($message, 400);
        }

        /*
         * Handle authentication error thrown using AuthenticationException.
         *
         */
        if ($exception instanceof AuthenticationException) {
            $message = $exception->getMessage();

            return $this->error($message, 401);
        }

        $statusCode = $this->getStatusCode($exception);

        if (! isset($message) && ! ($message = $exception->getMessage())) {
            $message = sprintf('%d %s', $statusCode, 'statusCode');
        }

        $errors = $message;

        if ($debugEnabled) {
            $errors = [];
            $errors[] = $message;
            // $errors['exception'] = get_class($exception);
            // $errors['trace'] = explode("\n", $exception->getTraceAsString());
        }

        return $this->error($errors, $statusCode);
    }

    /**
     * Get the status code from the exception.
     *
     * @param \Exception $exception
     * @return int
     */
    protected function getStatusCode(Throwable $exception)
    {
        
        return $exception instanceof HttpException ? $exception->getStatusCode() : 500;
    }
}