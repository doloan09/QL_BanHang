<?php

namespace App\Orchid\Screens\Color;

use App\Models\Color;
use App\Orchid\Layouts\Color\ColorEditLayout;
use App\Orchid\Layouts\Color\ColorListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ColorListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'colors' => Color::query()->paginate(),

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
                ->modal('colorModal')
                ->modalTitle('Thêm mới màu sắc')
                ->set('style', 'color: white; background-color: orange; border-radius: 5px;')
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
            ColorListLayout::class,

            Layout::modal('asyncEditColorModal', ColorEditLayout::class)
                ->async('asyncGetData')
                ->applyButton('Cập nhật'),

            Layout::modal('colorModal', [
                ColorEditLayout::class
            ])->applyButton('Thêm mới'),

        ];
    }

    public function asyncGetData(Color $color): iterable
    {
        return [
            'color' => $color,
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $color = Color::query()->create([
            'name' => $request->get('name'),
        ]);

        if ($color) {
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
            Color::query()->findOrFail($id)->update(['name' => $name,]);

            Toast::success('Cập nhật thành công!');
        } catch (\Exception) {
            Toast::error('Lỗi khi cập nhật thông tin!');
        }
    }

    public function delete(Request $request){
        try {
            $id = $request->get('id');
            Color::query()->findOrFail($id)->delete();

            Toast::success('Xóa thành công!');
        }catch (\Exception){
            Toast::error('Bạn không thể xóa!');
        }
    }

}
