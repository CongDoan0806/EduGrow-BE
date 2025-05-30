<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/api/*',
        '/api/login',
        '/api/learning-journal',
        '/api/learning-journal/week/${weekNumber}',
        '/api/Add-user',
        'api/profile',
        'api/changePassword',
        'api/study-plans',
        '/api/study-plans/*',
        'api/teacher/tags'
        ];
}
