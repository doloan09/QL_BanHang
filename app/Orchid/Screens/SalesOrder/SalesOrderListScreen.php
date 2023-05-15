<?php

namespace App\Orchid\Screens\SalesOrder;

use App\Enum\SalesOrderStatus;
use App\Models\SalesOrder;
use App\Orchid\Layouts\SalesOrder\SalesOrderFilterLayout;
use App\Orchid\Layouts\SalesOrder\SalesOrderListLayout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class SalesOrderListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'sales_orders' => SalesOrder::query()
                ->filters(SalesOrderFilterLayout::class)
                ->orderBy('status')
                ->paginate(),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Danh sách đơn hàng';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Xác nhận')
                ->icon('check')
                ->set('style', 'color: white; background-color: orange; border-radius: 5px; ')
                ->method('updateList'),

        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SalesOrderFilterLayout::class,
            SalesOrderListLayout::class,

        ];
    }

    public function update(Request $request)
    {
        try {
            $status = $request->get('status');
            if ($status == SalesOrderStatus::wait_confirm) {
                SalesOrder::query()->findOrFail($request->get('id'))->update([
                    'status'       => SalesOrderStatus::confirmed,
                    'time_confirm' => Carbon::now(),
                ]);
            } elseif ($status == SalesOrderStatus::confirmed) {
                SalesOrder::query()->findOrFail($request->get('id'))->update([
                    'status'        => SalesOrderStatus::delivered,
                    'time_delivery' => Carbon::now(),
                ]);
            }

            Toast::success('Xác nhận đơn hàng thành công!');
        } catch (\Exception $exception) {
            Toast::error('Có lỗi khi xác nhận đơn hàng!');
        }
    }

    public function updateList(Request $request)
    {
        try {
            $list = $request->get('check');

            if ($list) {
                foreach ($list as $item) {
                    $sale = SalesOrder::query()->findOrFail($item);
                    if ($sale->status->value == SalesOrderStatus::wait_confirm) {
                        $sale->update([
                            'status'       => SalesOrderStatus::confirmed,
                            'time_confirm' => Carbon::now(),
                        ]);
                    }
                }

                Toast::success('Xác nhận thành công!');
            } else {
                Toast::error('Vui lòng chọn đơn hàng trước khi nhấn xác nhân!');
            }
        } catch (\Exception $exception) {
            Toast::error('Có lỗi!');
        }
    }

}
