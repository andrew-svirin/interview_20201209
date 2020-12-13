<?php

namespace AndrewSvirin\Interview\Models;

/**
 * Model Airplane class.
 *
 * @property int $id
 * @property int $ticket_order_id
 * @property int $row_number
 * @property int $sit_number
 */
class Ticket extends Model
{

    /**
     * @inheritDoc
     */
    protected array $attributes = [
        'id',
        'ticket_order_id',
        'row_number',
        'sit_number',
    ];
}
