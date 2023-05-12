<?php

namespace App\Orchid\Layouts\Color;

use App\Models\Color;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ColorListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'colors';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),

            TD::make('name', 'Name'),

            TD::make(__('Thao tác'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Color $color) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        ModalToggle::make('Sửa')
                            ->icon('pencil')
                            ->set('style', 'color: blue')
                            ->modal('asyncEditColorModal')
                            ->modalTitle('Màu sắc')
                            ->method('save')
                            ->asyncParameters([
                                'group' => $color->id,
                            ]),

                        Button::make('Xóa')
                            ->set('style', 'color: red')
                            ->confirm('Bạn có muốn xóa không!')
                            ->method('delete', ['id' => $color->id])
                            ->icon('trash'),
                    ])),

        ];
    }
}
