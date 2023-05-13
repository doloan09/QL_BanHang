<?php

namespace App\Enum;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

class SalesOrderStatus extends Enum
{
    #[Description('Chờ xác nhận')]
    public const wait_confirm = 0;

    #[Description('Đã xác nhận')]
    public const confirmed = 1;

    #[Description('Đã giao hàng')]
    public const delivered = 2;

}
