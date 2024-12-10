<?php

namespace App\Services;

use App\Contracts\CepInterface;
use Illuminate\Support\Facades\Http;

class CepService implements CepInterface
{
    protected $provider;

    public function __construct()
    {
        $this->provider = config('services.api_cep');
    }

    public function consultar(string $cep)
    {
        $url = str_replace('%', $cep, $this->provider);

        try {
            return Http::get($url)->json();
        } catch (\Throwable $throwable) {
            return $throwable;
        }
    }
}
