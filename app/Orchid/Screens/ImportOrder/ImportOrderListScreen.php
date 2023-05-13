<?php

namespace App\Orchid\Screens\ImportOrder;

use App\Http\Requests\ImportOrderRequest;
use App\Models\ImportOrder;
use App\Orchid\Layouts\ImportOrder\ImportOrderEditLayout;
use App\Orchid\Layouts\ImportOrder\ImportOrderFilterLayout;
use App\Orchid\Layouts\ImportOrder\ImportOrderListLayout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ImportOrderListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'import_orders' => ImportOrder::query()
                ->filters(ImportOrderFilterLayout::class)
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
        return 'Danh sách đơn hàng nhập';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Thêm mới')
                ->modal('createModal')
                ->modalTitle('Thêm mới sản phẩm')
                ->method('store')
                ->icon('plus'),

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
            ImportOrderFilterLayout::class,

            ImportOrderListLayout::class,

            Layout::modal('asyncEditModal', ImportOrderEditLayout::class)
                ->async('asyncGetData')
                ->applyButton('Cập nhật'),

            Layout::modal('createModal', [
                ImportOrderEditLayout::class
            ])->applyButton('Thêm mới'),

        ];
    }

    public function asyncGetData(ImportOrder $importOrder): iterable
    {
        return [
            'import_order' => $importOrder,
        ];
    }

    public function store(ImportOrderRequest $request)
    {
        try {
            ImportOrder::query()->create([
                'product_id' => $request->get('product_id'),
                'supplier_id' => $request->get('supplier_id'),
                'number_of_import' => $request->get('number_of_import'),
            ]);

            Toast::success('Thêm mới thành công!');
        }catch (\Exception $exception){
            Toast::error('Có lỗi khi thêm mới!');
        }
    }

    public function save(ImportOrderRequest $request)
    {
        try {
            ImportOrder::query()->findOrFail($request->get('id'))->update([
                'product_id' => $request->get('product_id'),
                'supplier_id' => $request->get('supplier_id'),
                'number_of_import' => $request->get('number_of_import'),
            ]);

            Toast::success('Cập nhật thành công!');
        } catch (\Exception) {
            Toast::error('Lỗi khi cập nhật thông tin!');
        }
    }

}
