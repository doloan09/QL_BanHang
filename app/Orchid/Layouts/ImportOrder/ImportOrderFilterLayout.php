<?php

namespace App\Orchid\Layouts\ImportOrder;

use App\Models\Supplier;
use App\Orchid\Filters\SelectFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ImportOrderFilterLayout extends Selection
{
    public $template = self::TEMPLATE_LINE;
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        $suppliers = Supplier::query()->get();
        $list_supplier = [];

        foreach ($suppliers as $item){
            $list_supplier[$item->id] = $item->name;
        }

        return [
            SelectFilter::make('supplier_id', 'Nhà cung cấp', $list_supplier),

        ];
    }
}
