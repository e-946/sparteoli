<?php

namespace App\Support;

/**
 * Allowlist of Occurrence fields selectable for an occurrence report.
 *
 * Single source of truth for: which fields a client may request (validation),
 * how to build the Eloquent select()/with() for the job's query, and the
 * column headers used in the CSV/PDF output.
 */
final class OccurrenceReportFields
{
    public const array COLUMNS = [
        'date' => ['label' => 'Data', 'column' => 'date'],
        'call_time' => ['label' => 'Hora do chamado', 'column' => 'call_time'],
        'arrival_time' => ['label' => 'Hora de chegada', 'column' => 'arrival_time'],
        'end_time' => ['label' => 'Hora de término', 'column' => 'end_time'],
        'nature' => ['label' => 'Natureza', 'relation' => 'type.nature', 'accessor' => 'name', 'fk' => 'type_id'],
        'type' => ['label' => 'Tipo', 'relation' => 'type', 'accessor' => 'name', 'fk' => 'type_id'],
        'meanused' => ['label' => 'Meio de chamado', 'relation' => 'meanused', 'accessor' => 'name', 'fk' => 'meanused_id'],
        'zip_code' => ['label' => 'CEP', 'column' => 'zip_code'],
        'address' => ['label' => 'Endereço', 'column' => 'address'],
        'neighborhood' => ['label' => 'Bairro', 'column' => 'neighborhood'],
        'city' => ['label' => 'Cidade', 'column' => 'city'],
        'state' => ['label' => 'Estado', 'column' => 'state'],
        'requester' => ['label' => 'Solicitante', 'column' => 'requester'],
        'requester_phone' => ['label' => 'Telefone do solicitante', 'column' => 'requester_phone'],
        'resume' => ['label' => 'Resumo', 'column' => 'resume'],
        'placefreature' => ['label' => 'Característica do local', 'relation' => 'placefreature', 'accessor' => 'name', 'fk' => 'placefreature_id'],
        'placeuse' => ['label' => 'Utilização do local', 'relation' => 'placeuse', 'accessor' => 'name', 'fk' => 'placeuse_id'],
        'place_preservation' => ['label' => 'Local preservado', 'column' => 'place_preservation'],
        'filler_name' => ['label' => 'Preenchido por', 'column' => 'filler_name'],
        'filler_patent' => ['label' => 'Patente', 'column' => 'filler_patent'],
        'user' => ['label' => 'Cadastrado por', 'relation' => 'user', 'accessor' => 'name', 'fk' => 'user_id'],
        'created_at' => ['label' => 'Criado em', 'column' => 'created_at'],
    ];

    public static function isValid(string $field): bool
    {
        return array_key_exists($field, self::COLUMNS);
    }

    /**
     * @return array<string, string> field key => label, for the frontend field picker
     */
    public static function labels(): array
    {
        return array_map(static fn (array $meta): string => $meta['label'], self::COLUMNS);
    }

    /**
     * @param  array<int, string>  $fields
     * @return array{select: array<int, string>, with: array<int, string>}
     */
    public static function resolve(array $fields): array
    {
        $select = ['id'];
        $with = [];

        foreach ($fields as $field) {
            if (! self::isValid($field)) {
                continue;
            }

            $meta = self::COLUMNS[$field];

            if (isset($meta['column'])) {
                $select[] = $meta['column'];
            }

            if (isset($meta['relation'], $meta['fk'])) {
                $select[] = $meta['fk'];
                $with[] = $meta['relation'];
            }
        }

        return [
            'select' => array_values(array_unique($select)),
            'with' => array_values(array_unique($with)),
        ];
    }

    public static function label(string $field): string
    {
        return self::COLUMNS[$field]['label'] ?? $field;
    }

    public static function value(object $occurrence, string $field): mixed
    {
        $meta = self::COLUMNS[$field] ?? null;

        if ($meta === null) {
            return null;
        }

        return array_key_exists('column', $meta)
            ? $occurrence->{$meta['column']}
            : data_get($occurrence, "{$meta['relation']}.{$meta['accessor']}");
    }
}
