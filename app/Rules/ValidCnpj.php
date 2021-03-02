<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCnpj implements Rule
{
    public function passes($attribute, $value)
    {
        $value = preg_replace('/[^0-9]/', '', (string) $value);
        
        // Valida tamanho
        if (strlen($value) != 14)
            return false;
        
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++){
            $soma += $value{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        
        if ($value{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        
        // Valida segundo dígito verificador
        
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++){
            $soma += $value{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        
        return $value{13} == ($resto < 2 ? 0 : 11 - $resto);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'CNPJ inválido.';
    }
}