<?php

namespace App\Orchid\Layouts\Supplier;

use App\Models\Supplier;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SupplierListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'suppliers';

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

            TD::make('phone', 'Phone'),

            TD::make('address', 'Address'),

            TD::make(__('Thao tác'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Supplier $supplier) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        ModalToggle::make('Sửa')
                            ->icon('pencil')
                            ->set('style', 'color: blue')
                            ->modal('asyncEditModal')
                            ->modalTitle('Nhà cung cấp')
                            ->method('save')
                            ->asyncParameters([
                                'group' => $supplier->id,
                            ]),

                        Button::make('Xóa')
                            ->set('style', 'color: red')
                            ->confirm('Bạn có muốn xóa không!')
                            ->method('delete', ['id' => $supplier->id])
                            ->icon('trash'),
                    ])),

        ];
    }
}
