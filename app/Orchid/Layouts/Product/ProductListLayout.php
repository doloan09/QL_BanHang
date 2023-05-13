<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),

            TD::make('name', 'Tên sản phẩm'),

            TD::make('ingredient', 'Thành phần'),

            TD::make('category_id', 'Danh mục')
                ->render(function (Product $product) {
                    $category = $product->category;
                    return $category->name;
                }),

            TD::make('supplier_id', 'Nhà cung cấp')
                ->render(function (Product $product) {
                    $supplier = $product->supplier;
                    return $supplier->name;
                }),

            TD::make('total', 'Tổng số lượng'),

            TD::make(__('Thao tác'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn(Product $product) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        ModalToggle::make('Sửa')
                            ->icon('pencil')
                            ->set('style', 'color: blue')
                            ->modal('asyncEditModal')
                            ->modalTitle('Sản phẩm')
                            ->method('save')
                            ->asyncParameters([
                                'group' => $product->id,
                            ]),

                        Button::make('Xóa')
                            ->set('style', 'color: red')
                            ->confirm('Bạn có muốn xóa không!')
                            ->method('delete', ['id' => $product->id])
                            ->icon('trash'),
                    ])),

        ];
    }
}
