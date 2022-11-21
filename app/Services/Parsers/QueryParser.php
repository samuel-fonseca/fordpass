<?php

namespace App\Services\Parsers;

use Illuminate\Support\Collection;

class QueryParser implements Parser
{
    private string $queryString;

    private Collection $parser;

    public function __construct(
        protected string $url
    ) {
        $this->queryString = parse_url($this->url, PHP_URL_QUERY);
        $this->parser = collect(explode('&', $this->queryString))->mapWithKeys(function ($item) {
            $parts = explode('=', $item);

            return [
                $parts[0] ?? '' => $parts[1] ?? '',
            ];
        });
    }

    public function find(string $key): mixed
    {
        return $this->parser->get($key, null);
    }
}
