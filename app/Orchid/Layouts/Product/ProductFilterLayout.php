<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Category;
use App\Models\Supplier;
use App\Orchid\Filters\SelectFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ProductFilterLayout extends Selection
{
    public $template = self::TEMPLATE_LINE;
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        $categories = Category::query()->get();
        $list_category = [];

        foreach ($categories as $item){
            $list_category[$item->id] = $item->name;
        }

        ///
        $suppliers = Supplier::query()->get();
        $list_supplier = [];

        foreach ($suppliers as $item){
            $list_supplier[$item->id] = $item->name;
        }

        return [
            SelectFilter::make('category_id', 'Danh mục', $list_category),
            SelectFilter::make('supplier_id', 'Nhà cung cấp', $list_supplier),
        ];
    }
}
