<?php

/*
|------------------------------------------------
| Application Routes
|------------------------------------------------
*/

$app->get('/', function(){
    return view('docs');
});

/*
|------------------------------------------------
| Endpoints (See README for reference)
|------------------------------------------------
*/

// GET all ranking songs and albums on {date}
$app->get('charts/{date}', [
	'as' => 'charts',
	'uses' => 'ApiController@charts'
]);

// GET all ranking songs on {date}
$app->get('rank/{filter}/{num}', [
	'as' => 'ranking',
	'uses' => 'ApiController@ranking'
]);

// GET all albums and songs credited to artist
$app->get('artist/{id}', [
	'as' => 'artist',
	'uses' => 'ApiController@artist'
]);

// GET all weeks and placement during which the album/song was ranking
$app->get('music/{filter}/{id}', [
	'as' => 'album',
	'uses' => 'ApiController@music'
]);

// GET search results from the specified table
$app->get('search/{table}', [
	'as' => 'search',
	'uses' => 'ApiController@search'
]);