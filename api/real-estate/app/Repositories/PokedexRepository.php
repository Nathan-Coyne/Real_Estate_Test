<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class PokedexRepository
{
    const BASE_URL = 'https://pokeapi.co/api/v2/';
    const END_URL = 'pokemon';

    public static function getPokemonByName(string $name): \Illuminate\Http\Client\Response
    {
        return Http::get(self::BASE_URL . self::END_URL . '/' . $name);
    }

    public static function getAllPokemon(int $limit = 20, int $offset = 0): \Illuminate\Http\Client\Response
    {
        return Http::get(self::BASE_URL . self::END_URL . "?limit={$limit}&offset={$offset}");
    }
}
