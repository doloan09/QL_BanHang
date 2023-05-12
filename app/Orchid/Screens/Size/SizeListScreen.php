<?php

namespace App\Orchid\Screens\Size;

use App\Models\Size;
use App\Orchid\Layouts\Size\SizeEditLayout;
use App\Orchid\Layouts\Size\SizeListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SizeListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'sizes' => Size::query()->paginate(),

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
                ->modal('sizeModal')
                ->modalTitle('Thêm mới size')
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
            SizeListLayout::class,

            Layout::modal('asyncEditSizeModal', SizeEditLayout::class)
                ->async('asyncGetData')
                ->applyButton('Cập nhật'),

            Layout::modal('sizeModal', [
                SizeEditLayout::class
            ])->applyButton('Thêm mới'),

        ];
    }

    public function asyncGetData(Size $size): iterable
    {
        return [
            'size' => $size,
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $size = Size::query()->create([
            'name' => $request->get('name'),
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
            'name' => 'required',
        ]);

        $id   = $request->get('id');
        $name = $request->get('name');

        try {
            Size::query()->findOrFail($id)->update(['name' => $name,]);

            Toast::success('Cập nhật thành công!');
        } catch (\Exception) {
            Toast::error('Lỗi khi cập nhật thông tin!');
        }
    }

    public function delete(Request $request){
        try {
            $id = $request->get('id');
            Size::query()->findOrFail($id)->delete();

            Toast::success('Xóa thành công!');
        }catch (\Exception){
            Toast::error('Bạn không thể xóa!');
        }
    }

}
