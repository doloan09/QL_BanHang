<?php

namespace App\Orchid\Layouts\SalesOrder;

use App\Models\SalesOrder;
use Carbon\Carbon;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SalesOrderListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'sales_orders';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),

            TD::make('')
                ->width(20)
                ->render(function (SalesOrder $salesOrder) {
                    return
                        CheckBox::make('check[]')
                            ->name('check[]')
                            ->value($salesOrder->id)
                            ->checked(false);
                }),

            TD::make('Khách hàng')
                ->render(function (SalesOrder $salesOrder){
                    return '<p>Tên: ' . $salesOrder->user->name . '</p><p>Email: ' . $salesOrder->user->email . '</p><p>SDT: ' . $salesOrder->user->phone . '</p><p>Địa chỉ: ' . $salesOrder->user->address . '</p>';
                }),

            TD::make('Sản phẩm')
                ->render(function (SalesOrder $salesOrder){
                    return $salesOrder->product->name;
                }),

            TD::make('number_of_sell', 'Số lượng'),

            TD::make('color', 'Màu sắc'),

            TD::make('size', 'Size'),

            TD::make('status', 'Trạng thái')
                ->render(function (SalesOrder $salesOrder) {
                    return $salesOrder->status->description;
                }),

            TD::make('time_confirm', 'Thời gian xác nhận')
                ->render(function (SalesOrder $salesOrder){
                    return $salesOrder->time_confirm ? Carbon::parse($salesOrder->time_confirm)->format('d-m-Y H:i:s') : "";
                }),

            TD::make('time_delivery', 'Thời gian giao hàng')
                ->render(function (SalesOrder $salesOrder){
                    return $salesOrder->time_delivery ? Carbon::parse($salesOrder->time_delivery)->format('d-m-Y H:i:s') : "";
                }),

            TD::make('Thao tác')
                ->width(30)
                ->render(function (SalesOrder $salesOrder) {
                    if (!$salesOrder->time_confirm) {
                        return Button::make('Xác nhận')
                            ->icon('check')
                            ->method('update', ['id' => $salesOrder->id, 'status' => $salesOrder->status->value]);
                    }

                    return Button::make('Xác nhận')
                        ->icon('check')
                        ->set('disabled');

                }),

            TD::make()
                ->width(30)
                ->render(function (SalesOrder $salesOrder) {
                    if (!$salesOrder->time_delivery && $salesOrder->time_confirm) {
                        return Button::make('Giao hàng')
                            ->icon('action-redo')
                            ->method('update', ['id' => $salesOrder->id, 'status' => $salesOrder->status->value]);
                    }

                    return Button::make('Giao hàng')
                        ->icon('action-redo')
                        ->set('disabled');

                }),

        ];
    }
}
