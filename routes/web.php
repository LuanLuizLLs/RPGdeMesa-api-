<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
  return $router->app->version();
});

$router->group(['prefix' => 'tests'], function () use ($router) {
  $router->get('views/{path}/{view}', 'TestsController@views');
  $router->post('mails/{content}', 'TestsController@mails');
});

$router->group(['prefix' => 'services'], function () use ($router) {
  $router->get('/sse/{id}', 'SseController@index');
});

$router->group(['prefix' => 'auth'], function () use ($router) {
  $router->get('/me', 'AuthController@me');
  $router->post('/login', 'AuthController@login');
  $router->post('/logout', 'AuthController@logout');
  $router->post('/register', 'AuthController@register');
  $router->post('/send-code', 'AuthController@sendCode');
  $router->post('/confirm-code', 'AuthController@confirmCode');
  $router->patch('/recover', 'AuthController@recover');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'notifications'], function () use ($router) {
  $router->post('/', 'NotificationsController@create');
  $router->get('/', 'NotificationsController@read');
  $router->patch('/', 'NotificationsController@update');
  $router->delete('/', 'NotificationsController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'users'], function () use ($router) {
  $router->post('/', 'UsersController@create');
  $router->get('/', 'UsersController@read');
  $router->patch('/', 'UsersController@update');
  $router->delete('/', 'UsersController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'campaigns'], function () use ($router) {
  $router->post('/', 'CampaignsController@create');
  $router->get('/', 'CampaignsController@read');
  $router->patch('/', 'CampaignsController@update');
  $router->delete('/', 'CampaignsController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'adventures'], function () use ($router) {
  $router->post('/', 'AdventuresController@create');
  $router->get('/', 'AdventuresController@read');
  $router->patch('/', 'AdventuresController@update');
  $router->delete('/', 'AdventuresController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'scenarios'], function () use ($router) {
  $router->post('/', 'ScenariosController@create');
  $router->get('/', 'ScenariosController@read');
  $router->patch('/', 'ScenariosController@update');
  $router->delete('/', 'ScenariosController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'interactions'], function () use ($router) {
  $router->post('/', 'InteractionsController@create');
  $router->get('/', 'InteractionsController@read');
  $router->patch('/', 'InteractionsController@update');
  $router->delete('/', 'InteractionsController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'interactions-board'], function () use ($router) {
  $router->post('/', 'InteractionsBoardController@create');
  $router->get('/', 'InteractionsBoardController@read');
  $router->patch('/', 'InteractionsBoardController@update');
  $router->delete('/', 'InteractionsBoardController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'explorations'], function () use ($router) {
  $router->post('/', 'ExplorationsController@create');
  $router->get('/', 'ExplorationsController@read');
  $router->patch('/', 'ExplorationsController@update');
  $router->delete('/', 'ExplorationsController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'explorations-board'], function () use ($router) {
  $router->post('/', 'ExplorationsBoardController@create');
  $router->get('/', 'ExplorationsBoardController@read');
  $router->patch('/', 'ExplorationsBoardController@update');
  $router->delete('/', 'ExplorationsBoardController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'characters'], function () use ($router) {
  $router->post('/', 'CharactersController@create');
  $router->get('/', 'CharactersController@read');
  $router->patch('/', 'CharactersController@update');
  $router->delete('/', 'CharactersController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'features'], function () use ($router) {
  $router->post('/', 'FeaturesController@create');
  $router->get('/', 'FeaturesController@read');
  $router->patch('/', 'FeaturesController@update');
  $router->delete('/', 'FeaturesController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'abilities'], function () use ($router) {
  $router->post('/', 'AbilitiesController@create');
  $router->get('/', 'AbilitiesController@read');
  $router->patch('/', 'AbilitiesController@update');
  $router->delete('/', 'AbilitiesController@delete');
});

$router->group(['middleware' => ['auth', 'jwt'], 'prefix' => 'items'], function () use ($router) {
  $router->post('/', 'ItemsController@create');
  $router->get('/', 'ItemsController@read');
  $router->patch('/', 'ItemsController@update');
  $router->delete('/', 'ItemsController@delete');
});
