<?php

namespace App\Orchid\Screens\SalesOrder;

use App\Enum\SalesOrderStatus;
use App\Models\SalesOrder;
use App\Orchid\Layouts\SalesOrder\SalesOrderListLayout;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                ->orderByDesc('created_at')
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
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SalesOrderListLayout::class,

        ];
    }

    public function update(Request $request)
    {
        try {
            SalesOrder::query()->findOrFail($request->get('id'))->update([
                'status' => SalesOrderStatus::confirmed,
                'time_confirm' => Carbon::now(),
            ]);

            Toast::success('Xác nhận đơn hàng thành công!');
        }catch (\Exception $exception){
            Toast::error('Có lỗi khi xác nhận đơn hàng!');
        }
    }

}
