<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users', 'User1Controller@getUsers'); // Get all users
    $router->post('/users', 'User1Controller@add'); // Create user
    $router->get('/users/{id}', 'User1Controller@show'); // Get user by ID
    $router->put('/users/{id}', 'User1Controller@update'); // Update user
    $router->delete('/users/{id}', 'User1Controller@delete'); // Delete user
    $router->get('/usersjob', 'UserJobController@index'); // Get all jobs
    $router->get('/userjob/{id}', 'UserJobController@show');
});