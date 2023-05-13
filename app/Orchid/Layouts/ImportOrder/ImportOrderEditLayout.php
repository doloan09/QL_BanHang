<?php

namespace App\Orchid\Layouts\ImportOrder;

use App\Models\Product;
use App\Models\Supplier;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class ImportOrderEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $import_order = $this->query->get('import_order');

        return [
            Input::make('id')
                ->hidden()
                ->value($import_order->id ?? ""),

            Select::make('product_id')
                ->title('Sản phẩm')
                ->required()
                ->fromModel(Product::class, 'name'),

            Select::make('supplier_id')
                ->title('Nhà cung cấp')
                ->required()
                ->fromModel(Supplier::class, 'name'),

            Input::make('number_of_import')
                ->title('Số lượng nhập')
                ->required()
                ->value($import_order->number_of_import ?? 0),

        ];
    }
}
