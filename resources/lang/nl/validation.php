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

    'accepted'             => 'Het :attribute moet geaccepteerd worden.',
    'active_url'           => 'Het :attribute is geen geldige URL.',
    'after'                => 'Het :attribute moet een datum zijn na :date.',
    'after_or_equal'       => 'Het :attribute moet een datum zijn na of hetzelfde als :date.',
    'alpha'                => 'Het :attribute mag enkel letters bevatten.',
    'alpha_dash'           => 'Het :attribute mag enkel letters, nummers en streepjes bevatten.',
    'alpha_num'            => 'Het :attribute mag enkel letters en nummers bevatten.',
    'array'                => 'Het :attribute moet een array zijn.',
    'before'               => 'Het :attribute moet een datum zijn voor :date.',
    'before_or_equal'      => 'Het :attribute moet een datum zijn voor of hetzelfde als :date.',
    'between'              => [
        'numeric' => 'Het :attribute moet tussen :min en :max liggen.',
        'file'    => 'Het :attribute moet tussen :min en :max kilobytes liggen.',
        'string'  => 'Het :attribute moet tussen :min en :max karakters liggen.',
        'array'   => 'Het :attribute moet tussen :min en :max onderdelen bevatten.',
    ],
    'boolean'              => 'Het :attribute veld moet waar of niet waar zijn.',
    'confirmed'            => 'Het :attribute komt niet overeen.',
    'date'                 => 'Het :attribute is geen geldige datum.',
    'date_format'          => 'Het :attribute komt niet overeen met het formaat :format.',
    'different'            => 'Het :attribute en :other moeten verschillend zijn.',
    'digits'               => 'Het :attribute moet :digits getallen lang zijn.',
    'digits_between'       => 'Het :attribute moet een getal zijn dat :min en :max getallen lang is.',
    'dimensions'           => 'Het :attribute heeft bevat een afbeelding met ongeldige afmetingen.',
    'distinct'             => 'Het :attribute veld heeft een dubbele waarde.',
    'email'                => 'Het :attribute moet een geldig e-mailadres.',
    'exists'               => 'Het geselecteerde :attribute is niet geldig.',
    'file'                 => 'Het :attribute moet een bestand zijn.',
    'filled'               => 'Het :attribute veld moet een waarde hebben.',
    'image'                => 'Het :attribute moet een afbeelding zijn.',
    'in'                   => 'Het geselecteerde :attribute is niet geldig.',
    'in_array'             => 'Het :attribute veld bestaat niet in :other.',
    'integer'              => 'Het :attribute moet een getal zijn.',
    'ip'                   => 'Het :attribute moet een geldig IP adres zijn.',
    'ipv4'                 => 'Het :attribute moet een geldig IP adres versie 4 zijn.',
    'ipv6'                 => 'Het :attribute moet een geldig IP adres versie 6 zijn.',
    'json'                 => 'Het :attribute moet een geldige JSON tekst zijn.',
    'max'                  => [
        'numeric' => 'Het :attribute moet groter zijn dan :max.',
        'file'    => 'Het :attribute moet groter zijn dan :max kilobytes.',
        'string'  => 'Het :attribute moet meer dan :max karakters bevatten.',
        'array'   => 'Het :attribute moet meer dan :max onderdelen bevatten.',
    ],
    'mimes'                => 'Het :attribute moet een bestand zijn van het type: :values.',
    'mimetypes'            => 'Het :attribute moet een bestand zijn van het type: :values.',
    'min'                  => [
        'numeric' => 'Het :attribute moet kleiner zijn dan :min.',
        'file'    => 'Het :attribute moet kleiner zijn dan :min kilobytes.',
        'string'  => 'Het :attribute moet minder dan :min karakters bevatten.',
        'array'   => 'Het :attribute moet minder dan :min onderdelen bevatten.',
    ],
    'not_in'               => 'Het geselecteerde :attribute is niet geldig.',
    'numeric'              => 'Het :attribute moet een nummer zijn.',
    'present'              => 'Het :attribute veld moet aanwezig zijn.',
    'regex'                => 'Het :attribute formaat in niet geldig.',
    'required'             => 'Het :attribute veld is verplicht.',
    'required_if'          => 'Het :attribute veld is verplicht wanneer :other :value is.',
    'required_unless'      => 'Het :attribute veld is verplicht behalve als :other in :values zit.',
    'required_with'        => 'Het :attribute veld is verplicht wanneer :values aanwezig is.',
    'required_with_all'    => 'Het :attribute veld is verplicht wanneer :values aanwezig is.',
    'required_without'     => 'Het :attribute veld is verplicht wanneer :values niet aanwezig is.',
    'required_without_all' => 'Het :attribute veld is verplicht wanneer geen van deze :values aanwezig zijn.',
    'same'                 => 'Het :attribute en :other moeten hetzelfde zijn.',
    'size'                 => [
        'numeric' => 'Het :attribute moet :size zijn.',
        'file'    => 'Het :attribute moet :size kilobytes groot zijn.',
        'string'  => 'Het :attribute moet :size karakters lang zijn.',
        'array'   => 'Het :attribute moet :size onderdelen bevatten.',
    ],
    'string'               => 'Het :attribute moet een stuk tekst zijn.',
    'timezone'             => 'Het :attribute moet een geldige tijdzone zijn.',
    'unique'               => 'Het :attribute is al gebruikt geweest.',
    'uploaded'             => 'Het :attribute slaagde niet in het uploaden.',
    'url'                  => 'Het :attribute formaat is niet geldig.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
