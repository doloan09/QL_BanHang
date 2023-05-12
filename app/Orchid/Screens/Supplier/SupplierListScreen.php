<?php

namespace App\Orchid\Screens\Supplier;

use App\Models\Supplier;
use App\Orchid\Layouts\Supplier\SupplierEditLayout;
use App\Orchid\Layouts\Supplier\SupplierListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SupplierListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'suppliers' => Supplier::query()->paginate(),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Danh sách';
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
                ->modal('supplierModal')
                ->modalTitle('Thêm mới nhà cung cấp')
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
            SupplierListLayout::class,

            Layout::modal('asyncEditModal', SupplierEditLayout::class)
                ->async('asyncGetData')
                ->applyButton('Cập nhật'),

            Layout::modal('supplierModal', [
                SupplierEditLayout::class
            ])->applyButton('Thêm mới'),

        ];
    }

    public function asyncGetData(Supplier $supplier): iterable
    {
        return [
            'supplier' => $supplier,
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required',
        ]);

        $size = Supplier::query()->create([
            'name'    => $request->get('name'),
            'address' => $request->get('address'),
            'phone'   => $request->get('phone'),
        ]);

        if ($size) {
            Toast::success('Thêm mới thành công!');
        } else {
            Toast::error('Có lỗi khi thêm mới!');
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required',
        ]);

        $id   = $request->get('id');

        try {
            Supplier::query()->findOrFail($id)->update([
                'name'    => $request->get('name'),
                'address' => $request->get('address'),
                'phone'   => $request->get('phone'),
            ]);

            Toast::success('Cập nhật thành công!');
        } catch (\Exception) {
            Toast::error('Lỗi khi cập nhật thông tin!');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->get('id');
            Supplier::query()->findOrFail($id)->delete();

            Toast::success('Xóa thành công!');
        } catch (\Exception) {
            Toast::error('Bạn không thể xóa!');
        }
    }

}
