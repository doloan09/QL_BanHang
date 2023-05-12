<?php

namespace App\Orchid\Layouts\Size;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class SizeEditLayout extends Rows
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
        $size = $this->query->get('size');

        return [
            Input::make('id')
                ->hidden()
                ->value($size->id ?? ''),

            Input::make('name')
                ->required()
                ->title('Name')
                ->value($size->name ?? ''),

        ];
    }
}
