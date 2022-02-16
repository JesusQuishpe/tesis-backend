<?php

namespace App\Exceptions;

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
        $this->reportable(function (Throwable $e) {
            if($e instanceof ModelNotFoundException){
                return response()->json([
                    'message'=>$e->getMessage()
                ],404);
            }
        });

        $this->renderable(function (Throwable $e) {
            if($e instanceof NotFoundHttpException){
                return response()->json([
                    'message'=>'Registro no encontrado: '.$e->getMessage(),
                    'status'=>404
                ],404);
            }

            if($e instanceof ModelNotFoundException){
                return response()->json([
                    'message'=>'Modelo no encontrado'
                ],404);
            }
        });

        $this->renderable(function (Throwable $e) {
          if($e instanceof QueryException){
              return response()->json([
                'sql_code'=>$e->errorInfo[1],
                'message'=>$e->errorInfo[2]
              ],404);
          }

          if($e instanceof ModelNotFoundException){
              return response()->json([
                  'message'=>'Modelo no encontrado'
              ],404);
          }
      });
    }
}
