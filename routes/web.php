<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/** Route default */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

/** Routes users */
$router->group(['middleware' => ['auth'], 'prefix' => 'users'], function () use ($router) {
    $router->post('/create', 'UsersController@create');
    $router->get('/read', 'UsersController@read');
    $router->patch('/update', 'UsersController@update');
    $router->delete('/delete', 'UsersController@delete');
});

/** Routes campaigns */
$router->group(['middleware' => ['auth'], 'prefix' => 'campaigns'], function () use ($router) {
    $router->post('/create', 'CampaignsController@create');
    $router->get('/read', 'CampaignsController@read');
    $router->patch('/update', 'CampaignsController@update');
    $router->delete('/delete', 'CampaignsController@delete');
});

/** Routes adventures */
$router->group(['middleware' => ['auth'], 'prefix' => 'adventures'], function () use ($router) {
  $router->post('/create', 'AdventuresController@create');
  $router->get('/read', 'AdventuresController@read');
  $router->patch('/update', 'AdventuresController@update');
  $router->delete('/delete', 'AdventuresController@delete');
});

/** Routes scenarios */
$router->group(['middleware' => ['auth'], 'prefix' => 'scenarios'], function () use ($router) {
  $router->post('/create', 'ScenariosController@create');
  $router->get('/read', 'ScenariosController@read');
  $router->patch('/update', 'ScenariosController@update');
  $router->delete('/delete', 'ScenariosController@delete');
});

/** Routes characters */
$router->group(['middleware' => ['auth'], 'prefix' => 'characters'], function () use ($router) {
    $router->post('/create', 'CharactersController@create');
    $router->get('/read', 'CharactersController@read');
    $router->patch('/update', 'CharactersController@update');
    $router->delete('/delete', 'CharactersController@delete');
});

/** Routes features */
$router->group(['middleware' => ['auth'], 'prefix' => 'features'], function () use ($router) {
  $router->post('/create', 'FeaturesController@create');
  $router->get('/read', 'FeaturesController@read');
  $router->patch('/update', 'FeaturesController@update');
  $router->delete('/delete', 'FeaturesController@delete');
});

/** Routes abilities */
$router->group(['middleware' => ['auth'], 'prefix' => 'abilities'], function () use ($router) {
  $router->post('/create', 'AbilitiesController@create');
  $router->get('/read', 'AbilitiesController@read');
  $router->patch('/update', 'AbilitiesController@update');
  $router->delete('/delete', 'AbilitiesController@delete');
});