<?php

namespace App\Orchid\Layouts\Supplier;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class SupplierEditLayout extends Rows
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
        $supplier = $this->query->get('supplier');

        return [
            Input::make('id')
                ->hidden()
                ->value($supplier->id ?? ''),

            Input::make('name')
                ->required()
                ->title('Name')
                ->value($supplier->name ?? ''),

            Input::make('address')
                ->required()
                ->title('Address')
                ->value($supplier->address ?? ''),

            Input::make('phone')
                ->required()
                ->title('Phone')
                ->value($supplier->phone ?? ''),

        ];
    }
}
