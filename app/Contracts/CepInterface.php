<?php

namespace App\Contracts;

interface CepInterface
{
    /*
     * Consulta diretamente API externa para retornar o endereço pelo CEP
     */
    public function consultar(string $cep);
}
