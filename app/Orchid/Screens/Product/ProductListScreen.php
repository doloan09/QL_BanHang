<?php

namespace App\Orchid\Screens\Product;

use App\Http\Requests\ProductRequest;
use App\Models\ColorProduct;
use App\Models\Product;
use App\Models\SizeProduct;
use App\Orchid\Layouts\Product\ProductEditLayout;
use App\Orchid\Layouts\Product\ProductListLayout;
use App\Orchid\Layouts\Product\ProductFilterLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'products' => Product::query()
                ->filters(ProductFilterLayout::class)
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
        return 'Danh sách sản phẩm';
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
            ProductFilterLayout::class,
            ProductListLayout::class,

            Layout::modal('asyncEditModal', ProductEditLayout::class)
                ->async('asyncGetData')
                ->applyButton('Cập nhật'),

            Layout::modal('createModal', [
                ProductEditLayout::class
            ])->applyButton('Thêm mới'),

        ];
    }

    public function asyncGetData(Product $product): iterable
    {
        return [
            'product' => $product,
        ];
    }

    public function store(ProductRequest $request)
    {
        try {
            $color_list = $request->get('color_list');
            $size_list  = $request->get('size_list');

            $product = Product::query()->create([
                'name'        => $request->get('name'),
                'slug'        => Str::slug($request->get('name')),
                'ingredient'  => $request->get('ingredient'),
                'category_id' => $request->get('category_id'),
                'supplier_id' => $request->get('supplier_id'),
                'total'       => $request->get('total'),
            ]);

            foreach ($color_list as $item) {
                ColorProduct::query()->create([
                    'color_id'   => $item,
                    'product_id' => $product->id,
                ]);
            }

            foreach ($size_list as $item) {
                SizeProduct::query()->create([
                    'size_id'    => $item,
                    'product_id' => $product->id,
                ]);
            }

            Toast::success('Thêm mới thành công!');
        } catch (\Exception $exception) {
            Toast::error('Có lỗi khi thêm mới!');
        }
    }

    public function save(ProductRequest $request)
    {
        try {
            $id         = $request->get('id');
            $color_list = $request->get('color_list');
            $size_list  = $request->get('size_list');

            Product::query()->findOrFail($id)->update([
                'name'        => $request->get('name'),
                'slug'        => Str::slug($request->get('name')),
                'ingredient'  => $request->get('ingredient'),
                'category_id' => $request->get('category_id'),
                'supplier_id' => $request->get('supplier_id'),
                'total'       => $request->get('total'),
            ]);

            ColorProduct::query()->where('product_id', $id)->delete();
            SizeProduct::query()->where('product_id', $id)->delete();

            foreach ($color_list as $item) {
                ColorProduct::query()->create([
                    'color_id'   => $item,
                    'product_id' => $id,
                ]);
            }

            foreach ($size_list as $item) {
                SizeProduct::query()->create([
                    'size_id'    => $item,
                    'product_id' => $id,
                ]);
            }

            Toast::success('Cập nhật thành công!');
        } catch (\Exception) {
            Toast::error('Lỗi khi cập nhật thông tin!');
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->get('id');

            ColorProduct::query()->where('product_id', $id)->delete();
            SizeProduct::query()->where('product_id', $id)->delete();
            Product::query()->findOrFail($id)->delete();

            Toast::success('Xóa thành công!');
        } catch (\Exception) {
            Toast::error('Bạn không thể xóa sản phẩm này! Có nhiều ràng buộc liên quan');
        }
    }

}
