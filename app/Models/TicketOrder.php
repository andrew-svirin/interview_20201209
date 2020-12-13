<?php

namespace AndrewSvirin\Interview\Models;

/**
 * Model Airplane class.
 *
 * @property int $id
 * @property int $airplane_id
 * @property string $person_name
 */
class TicketOrder extends Model
{

    /**
     * @inheritDoc
     */
    protected array $attributes = [
        'id',
        'airplane_id',
        'person_name',
    ];
}
