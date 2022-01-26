<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute deve ser aceito.',
    'accepted_if' => ':attribute deve ser aceito queo :other for :value.',
    'active_url' => ':attribute não é uma URL válida.',
    'after' => ':attribute deve ter uma data depois de :date.',
    'after_or_equal' => ':attribute deve ter uma data depois ou igual a :date.',
    'alpha' => ':attribute deve conter apenas letras.',
    'alpha_dash' => ':attribute deve conter apenas letras, números, traços e underlines.',
    'alpha_num' => ':attribute deve conter apenas letras e números.',
    'array' => ':attribute deve ser um array.',
    'before' => ':attribute deve ser uma data antes de :date.',
    'before_or_equal' => ':attribute deve ser uma data antes ou igual a :date.',
    'between' => [
        'numeric' => ':attribute deve estar entre :min e :max.',
        'file' => ':attribute deve estar entre :min e :max kilobytes.',
        'string' => ':attribute deve estar entre :min e :max caracteres.',
        'array' => ':attribute deve ter entre :min e :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'Confirmação de :attribute não corresponde.',
    'current_password' => 'A senha é incorreta.',
    'date' => ':attribute não é uma data válida.',
    'date_equals' => ':attribute deve ser uma data igual a :date.',
    'date_format' => ':attribute não corresponde ao formato :format.',
    'different' => ':attribute e :other devem ser diferentes.',
    'digits' => ':attribute deve ter :digits digitos.',
    'digits_between' => ':attribute deve estar entre :min e :max digitos.',
    'dimensions' => ':attribute tem dimensões de imagem inválida.',
    'distinct' => 'O campo :attribute tem uma valor duplicado.',
    'email' => ':attribute deve ser um email válido.',
    'ends_with' => ':attribute deve terminar com um dos seguintes valores: :values.',
    'exists' => ':attribute selecionado é inválido.',
    'file' => ':attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve ser preenchido.',
    'gt' => [
        'numeric' => ':attribute deve ser maior que :value.',
        'file' => ':attribute deve ser maior que :value kilobytes.',
        'string' => ':attribute deve ser maior que :value caracteres.',
        'array' => ':attribute deve ter mais que :value itens.',
    ],
    'gte' => [
        'numeric' => ':attribute deve ser maior que ou igual a :value.',
        'file' => ':attribute deve ser maior que ou igual a :value kilobytes.',
        'string' => ':attribute deve ser maior que ou igual a :value caracteres.',
        'array' => ':attribute deve ter :value itens ou mais.',
    ],
    'image' => ':attribute deve ser uma imagem.',
    'in' => 'O :attribute selecionado(a) é inválido.',
    'in_array' => 'O campo :attribute não existe em :other.',
    'integer' => ':attribute deve ser um inteiro.',
    'ip' => ':attribute deve ser um endereço de IP válido.',
    'ipv4' => ':attribute deve ser um endereço de IPv4 válido.',
    'ipv6' => ':attribute deve ser um endereço de IPv6 válido.',
    'json' => ':attribute deve ser uma string de JSON válida.',
    'lt' => [
        'numeric' => ':attribute deve ser menor que :value.',
        'file' => ':attribute deve ser menor que :value kilobytes.',
        'string' => ':attribute deve ser menor que :value caracteres.',
        'array' => ':attribute deve ter menos que :value itens.',
    ],
    'lte' => [
        'numeric' => ':attribute deve ser menor ou igual a :value.',
        'file' => ':attribute deve ser menor que ou igual a :value kilobytes.',
        'string' => ':attribute deve ser menor que ou igual a :value caracteres.',
        'array' => ':attribute não deve ter mais que :value itens.',
    ],
    'max' => [
        'numeric' => ':attribute não deve ser maior que :max.',
        'file' => ':attribute não deve ser maior que :max kilobytes.',
        'string' => ':attribute não deve ser maior que :max caracteres.',
        'array' => ':attribute não deve ter mais que :max itens.',
    ],
    'mimes' => ':attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => ':attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => ':attribute deve ser no minimo :min.',
        'file' => ':attribute deve ser no minimo :min kilobytes.',
        'string' => ':attribute deve ter no minimo :min caracteres.',
        'array' => ':attribute deve ter no minimo :min itens.',
    ],
    'multiple_of' => ':attribute deve ser multiplo de :value.',
    'not_in' => ':attribute selecionado(a) é inválido.',
    'not_regex' => ':attribute formato é inválido.',
    'numeric' => ':attribute deve ser um número.',
    'password' => 'A senha está incorreta.',
    'present' => 'Campo :attribute deve estar presente.',
    'regex' => ':attribute formato é inválido.',
    'required' => 'Campo :attribute é obrigatório.',
    'required_if' => 'Campo :attribute é obrigatório quando :other for :value.',
    'required_unless' => 'Campo :attribute é obrigatório a menos que :other for :values.',
    'required_with' => 'Campo :attribute é obrigatório quando :values estiver presente.',
    'required_with_all' => 'Campo :attribute é obrigatório quando :values estiverem presentes.',
    'required_without' => 'Campo :attribute é obrigatório quando :values não estiver presente.',
    'required_without_all' => 'Campo :attribute é obrigatório quando nenhum deles :values estiverem presente.',
    'prohibited' => 'Campo :attribute field é proibido.',
    'prohibited_if' => 'Campo :attribute field é proibido qunado :other for :value.',
    'prohibited_unless' => 'Campo :attribute field é proibido a menos que :other for :values.',
    'prohibits' => 'Campo :attribute proíbe :other de estar presente.',
    'same' => ':attribute e :other deve ser iguais.',
    'size' => [
        'numeric' => ':attribute deve ter :size.',
        'file' => ':attribute deve ter :size kilobytes.',
        'string' => ':attribute deve ter :size caracteres.',
        'array' => ':attribute deve conter :size itens.',
    ],
    'starts_with' => ':attribute deve começar com um dos seguintes: :values.',
    'string' => ':attribute deve ser uma string.',
    'timezone' => ':attribute deve ser um fuso horário válido.',
    'unique' => ':attribute já está em uso.',
    'uploaded' => ':attribute falhou no upload.',
    'url' => ':attribute deve ser uma URL válida.',
    'uuid' => ':attribute deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
