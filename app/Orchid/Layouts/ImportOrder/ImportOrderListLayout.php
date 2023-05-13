<?php

namespace App\Orchid\Layouts\ImportOrder;

use App\Models\ImportOrder;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ImportOrderListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'import_orders';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),

            TD::make('product_id', 'Tên sản phẩm')
                ->render(function (ImportOrder $importOrder) {
                    return $importOrder->product->name;
                }),

            TD::make('supplier', 'Nhà cung cấp')
                ->render(function (ImportOrder $importOrder) {
                    return $importOrder->supplier->name;
                }),

            TD::make('number_of_import', 'Số lượng nhập'),

            TD::make('created_at', 'Thời gian nhập')
                ->render(function (ImportOrder $importOrder) {
                    return Carbon::parse($importOrder->created_at)->format('d-m-Y H:i:s');
                }),

            TD::make(__('Thao tác'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(ImportOrder $importOrder) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        ModalToggle::make('Sửa')
                            ->icon('pencil')
                            ->set('style', 'color: blue')
                            ->modal('asyncEditModal')
                            ->modalTitle('Đơn hàng nhập')
                            ->method('save')
                            ->asyncParameters([
                                'group' => $importOrder->id,
                            ]),

                    ])),

        ];
    }
}
