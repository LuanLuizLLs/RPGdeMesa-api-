<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['middleware' => ['auth'], 'prefix' => 'services'], function () use ($router) {
  $router->get('/sse', 'SseController@index');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'users'], function () use ($router) {
    $router->post('/create', 'UsersController@create');
    $router->get('/read', 'UsersController@read');
    $router->patch('/update', 'UsersController@update');
    $router->delete('/delete', 'UsersController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'campaigns'], function () use ($router) {
    $router->post('/create', 'CampaignsController@create');
    $router->get('/read', 'CampaignsController@read');
    $router->patch('/update', 'CampaignsController@update');
    $router->delete('/delete', 'CampaignsController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'adventures'], function () use ($router) {
  $router->post('/create', 'AdventuresController@create');
  $router->get('/read', 'AdventuresController@read');
  $router->patch('/update', 'AdventuresController@update');
  $router->delete('/delete', 'AdventuresController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'scenarios'], function () use ($router) {
  $router->post('/create', 'ScenariosController@create');
  $router->get('/read', 'ScenariosController@read');
  $router->patch('/update', 'ScenariosController@update');
  $router->delete('/delete', 'ScenariosController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'interactions'], function () use ($router) {
  $router->post('/create', 'InteractionsController@create');
  $router->get('/read', 'InteractionsController@read');
  $router->patch('/update', 'InteractionsController@update');
  $router->delete('/delete', 'InteractionsController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'interactions-board'], function () use ($router) {
  $router->post('/create', 'InteractionsBoardController@create');
  $router->get('/read', 'InteractionsBoardController@read');
  $router->patch('/update', 'InteractionsBoardController@update');
  $router->delete('/delete', 'InteractionsBoardController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'explorations'], function () use ($router) {
  $router->post('/create', 'ExplorationsController@create');
  $router->get('/read', 'ExplorationsController@read');
  $router->patch('/update', 'ExplorationsController@update');
  $router->delete('/delete', 'ExplorationsController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'explorations-board'], function () use ($router) {
  $router->post('/create', 'ExplorationsBoardController@create');
  $router->get('/read', 'ExplorationsBoardController@read');
  $router->patch('/update', 'ExplorationsBoardController@update');
  $router->delete('/delete', 'ExplorationsBoardController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'characters'], function () use ($router) {
    $router->post('/create', 'CharactersController@create');
    $router->get('/read', 'CharactersController@read');
    $router->patch('/update', 'CharactersController@update');
    $router->delete('/delete', 'CharactersController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'features'], function () use ($router) {
  $router->post('/create', 'FeaturesController@create');
  $router->get('/read', 'FeaturesController@read');
  $router->patch('/update', 'FeaturesController@update');
  $router->delete('/delete', 'FeaturesController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'abilities'], function () use ($router) {
  $router->post('/create', 'AbilitiesController@create');
  $router->get('/read', 'AbilitiesController@read');
  $router->patch('/update', 'AbilitiesController@update');
  $router->delete('/delete', 'AbilitiesController@delete');
});

$router->group(['middleware' => ['auth'], 'prefix' => 'items'], function () use ($router) {
  $router->post('/create', 'ItemsController@create');
  $router->get('/read', 'ItemsController@read');
  $router->patch('/update', 'ItemsController@update');
  $router->delete('/delete', 'ItemsController@delete');
});