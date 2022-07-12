<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
        $this->renderable(function (Throwable $e) {
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Registro no encontrado',
                    'exception_code' => $e->getCode(),
                    'exception_message' => $e->getMessage()
                ], 404);
            }

            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'Modelo no encontrado',
                    'exception_code' => $e->getCode(),
                    'exception_message' => $e->getMessage()
                ], 404);
            }
        });

        $this->renderable(function (Throwable $e) {
            if ($e instanceof QueryException) {
                $sql_code = $e->errorInfo[1];
                $sql_message = $e->errorInfo[2];
                if ($sql_code === 1451) {
                    return response()->json([
                        'sql_code' => $sql_code,
                        'sql_message' => $sql_message,
                        'message' => "No se puede eliminar, el registro está relacionado \n con otros datos.",
                        'exception_code' => $e->getCode(),
                        'exception_message' => $e->getMessage()
                    ], 409);
                }
                if ($sql_code === 1062) {
                    return response()->json([
                        'sql_code' => $sql_code,
                        'sql_message' => $sql_message,
                        'message' => "El registro que intenta crear ya existe..",
                        'exception_code' => $e->getCode(),
                        'exception_message' => $e->getMessage()
                    ], 409);
                }
            }
        });

        $this->renderable(function (Throwable $e) {
            if ($e instanceof Exception) {
                return response()->json([
                    'message' => "Ha ocurrido un error inesperado...",
                    'exception_code' => $e->getCode(),
                    'exception_message' => $e->getFile() + $e->getLine()
                ], 404);
            }
        });
    }
}
