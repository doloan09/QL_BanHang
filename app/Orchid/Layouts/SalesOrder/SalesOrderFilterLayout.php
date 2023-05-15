<?php

namespace App\Orchid\Layouts\SalesOrder;

use App\Enum\SalesOrderStatus;
use App\Orchid\Filters\SelectFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class SalesOrderFilterLayout extends Selection
{
    public $template = self::TEMPLATE_LINE;
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            SelectFilter::make('status', 'Trạng thái đơn hàng', SalesOrderStatus::asSelectArray()),

        ];
    }
}
