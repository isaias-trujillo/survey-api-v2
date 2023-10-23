<?php

namespace modules\shared\domain\fields;

final class Id extends Field
{
    public function __construct(string $input = null)
    {
        parent::__construct( $input ?? $this->generate() );
    }

    protected function ensure($input): string
    {
        if (empty($input)){
            throw new InvalidArgumentError("Id vacío.");
        }
        if (!is_string($input)){
            throw new InvalidArgumentError("El Id debe ser una cadena de caracteres.");
        }
        if (!preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $input)){
            throw new InvalidArgumentError("El Id tiene un patrón inválido");
        }
        return $input;
    }

    private function generate(): string
    {
        if (function_exists( 'com_create_guid' )) {
            /** @noinspection PhpUndefinedFunctionInspection */
            $result = trim( com_create_guid(), '{}' );
            return true ? strtolower( $result ) : $result;
        }
        $data = openssl_random_pseudo_bytes( 16 );
        $data[6] = chr( ord( $data[6] ) & 0x0f | 0x40 ); // set version to 0100
        $data[8] = chr( ord( $data[8] ) & 0x3f | 0x80 ); // set bits 6-7 to 10
        $result = vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split( bin2hex( $data ), 4 ) );
        return true ? strtolower( $result ) : $result;
    }
}