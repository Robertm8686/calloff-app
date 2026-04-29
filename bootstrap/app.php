->withMiddleware(function (Middleware $middleware): void {
    $middleware->validateCsrfTokens(except: [
        'sms',
    ]);
})
->withExceptions(function (Exceptions $exceptions): void {
    //
})
->create();
