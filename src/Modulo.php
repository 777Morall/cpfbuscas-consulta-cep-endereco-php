<?php
declare(strict_types=1);

/** Monta parâmetros; não realiza chamadas de rede. */
function prepararConsulta(array $args): array
{
    if (($args[0] ?? '')==='cep') {
        $cep=str_replace(['-',' '],'',$args[1] ?? '');
        if (!preg_match('/^[0-9]{8}$/D',$cep)) throw new InvalidArgumentException('CEP deve ter oito dígitos.');
        return ['cep',['cep'=>$cep]];
    }
    if (($args[0] ?? '')!=='endereco') throw new InvalidArgumentException('Escolha cep ou endereco.');
    $uf=strtoupper($args[1] ?? '');
    if (!in_array($uf,explode(' ','AC AL AP AM BA CE DF ES GO MA MT MS MG PA PB PR PE PI RJ RN RS RO RR SC SP SE TO'),true)) throw new InvalidArgumentException('UF inválida.');
    $logradouro=trim($args[2] ?? '');
    if ($logradouro==='') throw new InvalidArgumentException('Informe logradouro.');
    $params=['uf'=>$uf,'logradouro'=>$logradouro];
    if (trim($args[3] ?? '')!=='') $params['cidade']=trim($args[3]);
    return ['endereco',$params];
}
