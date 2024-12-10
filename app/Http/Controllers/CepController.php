<?php

namespace App\Http\Controllers;

use App\Contracts\CepInterface;
use Illuminate\Http\Request;

class CepController extends Controller
{
    public function __construct(
        protected CepInterface $cepRepository
    )
    {}

    public function consultar(string $cep)
    {
        return $this->cepRepository->consultar($cep);
    }
}
