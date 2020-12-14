<?php

namespace AndrewSvirin\Interview\Models;

/**
 * Model Airplane class.
 *
 * @property int $id
 * @property string $person_name
 */
class TicketOrder extends Model
{

    /**
     * @inheritDoc
     */
    protected array $attributes = [
        'id',
        'person_name',
    ];
}
