<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarvelCharacters;
use App\Http\Controllers\MarvelComics;
use App\Http\Controllers\MarvelCreators;
use App\Http\Controllers\MarvelSeries;
use App\Http\Controllers\MarvelStories;
use App\Http\Controllers\MarvelEvents;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    // marvel characters
    Route::get('characters', [MarvelCharacters::class, 'index']);
    Route::get('characters/{characterId}', [MarvelCharacters::class, 'characterById']);
    Route::get('characters/{characterId}/comics', [MarvelCharacters::class, 'comicByCharacterById']);
    Route::get('characters/{characterId}/events', [MarvelCharacters::class, 'eventByCharacterById']);
    Route::get('characters/{characterId}/series', [MarvelCharacters::class, 'seriesByCharacterById']);
    Route::get('characters/{characterId}/stories', [MarvelCharacters::class, 'storiesByCharacterById']);


    // marvel comics
    Route::get('comics', [MarvelComics::class, 'index']);
    Route::get('comics/{comicId}', [MarvelComics::class, 'fetchComicById']);
    Route::get('comics/{comicId}/characters', [MarvelComics::class, 'fetchComicCharactersByComicId']);
    Route::get('comics/{comicId}/creators', [MarvelComics::class, 'fetchComicCreatorsByComicId']);
    Route::get('comics/{comicId}/events', [MarvelComics::class, 'fetchComicEventsByComicId']);
    Route::get('comics/{comicId}/stories', [MarvelComics::class, 'fetchComicStoriesByComicId']);

    // marvel creators
    Route::get('creators', [MarvelComics::class, 'index']);
    Route::get('creators/{creatorId}', [MarvelCreators::class, 'fetchCreatorById']);
    Route::get('creators/{creatorId}/comics', [MarvelCreators::class, 'fetchComicCharactersByComicId']);
    Route::get('creators/{creatorId}/series', [MarvelCreators::class, 'fetchComicCreatorsByComicId']);
    Route::get('creators/{creatorId}/events', [MarvelCreators::class, 'fetchComicEventsByComicId']);
    Route::get('creators/{creatorId}/stories', [MarvelCreators::class, 'fetchComicStoriesByComicId']);


    // marvel events
    Route::get('events', [MarvelEvents::class, 'index']);
    Route::get('events/{eventId}', [MarvelEvents::class, 'fetchCreatorById']);
    Route::get('events/{eventId}/characters', [MarvelEvents::class, 'fetchComicCharactersByComicId']);
    Route::get('events/{eventId}/series', [MarvelEvents::class, 'fetchComicCreatorsByComicId']);
    Route::get('events/{eventId}/comics', [MarvelEvents::class, 'fetchComicEventsByComicId']);
    Route::get('events/{eventId}/stories', [MarvelEvents::class, 'fetchComicStoriesByComicId']);
    Route::get('events/{eventId}/creators', [MarvelEvents::class, 'fetchComicStoriesByComicId']);

    // marvel series
    Route::get('series', [MarvelSeries::class, 'index']);
    Route::get('series/{seriesId}', [MarvelSeries::class, 'fetchCreatorById']);
    Route::get('series/{seriesId}/characters', [MarvelSeries::class, 'fetchComicCharactersByComicId']);
    Route::get('series/{seriesId}/events', [MarvelSeries::class, 'fetchComicCreatorsByComicId']);
    Route::get('series/{seriesId}/comics', [MarvelSeries::class, 'fetchComicEventsByComicId']);
    Route::get('series/{seriesId}/stories', [MarvelSeries::class, 'fetchComicStoriesByComicId']);
    Route::get('series/{seriesId}/creators', [MarvelSeries::class, 'fetchComicStoriesByComicId']);

    // marvel series
    Route::get('stories', [MarvelStories::class, 'fetchComicStoriesByComicIdindex']);
    Route::get('stories/{storyId}', [MarvelStories::class, 'fetchCreatorById']);
    Route::get('stories/{storyId}/characters', [MarvelStories::class, 'fetchComicCharactersByComicId']);
    Route::get('stories/{storyId}/events', [MarvelStories::class, 'fetchComicCreatorsByComicId']);
    Route::get('stories/{storyId}/comics', [MarvelStories::class, 'fetchComicEventsByComicId']);
    Route::get('stories/{storyId}/series', [MarvelStories::class, 'fetchComicStoriesByComicId']);
    Route::get('stories/{storyId}/creators', [MarvelStories::class, 'fetchComicStoriesByComicId']);
});

