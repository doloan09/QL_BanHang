<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryEditLayout;
use App\Orchid\Layouts\Category\CategoryListLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'categories' => Category::query()->paginate(),

        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Danh sách danh mục sản phẩm';
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
                ->modalTitle('Thêm mới danh mục')
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
            CategoryListLayout::class,

            Layout::modal('asyncEditModal', CategoryEditLayout::class)
                ->async('asyncGetData')
                ->applyButton('Cập nhật'),

            Layout::modal('createModal', [
                CategoryEditLayout::class
            ])->applyButton('Thêm mới'),

        ];
    }

    public function asyncGetData(Category $category): iterable
    {
        return [
            'category' => $category,
        ];
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            Category::query()->create([
                'name' => $request->get('name'),
                'slug' => Str::slug($request->get('name')),
            ]);

            Toast::success('Thêm mới thành công!');
        }catch (\Exception $exception){
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
            Category::query()->findOrFail($id)->update([
                'name' => $name,
                'slug' => Str::slug($name),
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
            Category::query()->findOrFail($id)->delete();

            Toast::success('Xóa thành công!');
        } catch (\Exception) {
            Toast::error('Bạn không thể xóa!');
        }
    }

}
