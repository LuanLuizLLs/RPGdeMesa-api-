<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/** Route default */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

/** Routes users */
$router->group(['middleware' => ['auth'], 'prefix' => 'users'], function () use ($router) {
    $router->post('/create', 'UsersController@create');
    $router->get('/read[/{id}]', 'UsersController@read');
    $router->patch('/update[/{id}]', 'UsersController@update');
});

/** Routes campaings */
$router->group(['middleware' => ['auth'], 'prefix' => 'campaings'], function () use ($router) {
    $router->post('/create', 'CampaingsController@create');
    $router->get('/read[/{id}]', 'CampaingsController@read');
    $router->patch('/update/{id}', 'CampaingsController@update');
    $router->delete('/delete/{id}', 'CampaingsController@delete');
});

/** Routes characters */
$router->group(['middleware' => ['auth'], 'prefix' => 'characters'], function () use ($router) {
    $router->post('/create', 'CharactersController@create');
    $router->get('/read[/{id}]', 'CharactersController@read');
    $router->patch('/update/{id}', 'CharactersController@update');
    $router->delete('/delete/{id}', 'CharactersController@delete');
});

/** Routes features */
$router->group(['middleware' => ['auth'], 'prefix' => 'features'], function () use ($router) {
  $router->post('/create', 'FeaturesController@create');
  $router->get('/read[/{id}]', 'FeaturesController@read');
  $router->delete('/delete/{id}', 'FeaturesController@delete');
});

/** Routes abilities */
$router->group(['middleware' => ['auth'], 'prefix' => 'abilities'], function () use ($router) {
  $router->post('/create', 'AbilitiesController@create');
  $router->get('/read[/{id}]', 'AbilitiesController@read');
  $router->patch('/update/{id}', 'AbilitiesController@update');
  $router->delete('/delete/{id}', 'AbilitiesController@delete');
});