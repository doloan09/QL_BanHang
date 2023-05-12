<?php

namespace App\Orchid\Layouts\Color;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class ColorEditLayout extends Rows
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
        $color = $this->query->get('color');

        return [
            Input::make('id')
                ->hidden()
                ->value($color->id ?? ''),

            Input::make('name')
                ->required()
                ->title('Name')
                ->value($color->name ?? ''),

        ];
    }
}
