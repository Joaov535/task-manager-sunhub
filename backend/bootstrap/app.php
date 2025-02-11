<?php

use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        //web: __DIR__.'/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        //commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e) {
            return response()->json([
                'error' => 'Não autenticado',
                'message' => 'Você precisa estar autenticado para acessar esta rota.'
            ], 401);
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->json([
                'error' => 'Rota não encontrada',
                'message' => 'A rota que você tentou acessar não existe.'
            ], 404);
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e) {
            return response()->json([
                'error' => 'Método não permitido',
                'message' => 'O método HTTP utilizado não é suportado para esta rota.'
            ], 405);
        });

        $exceptions->render(function (\Throwable $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage()
            ], 500);
        });
    })->create();
