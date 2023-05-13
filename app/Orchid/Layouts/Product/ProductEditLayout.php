<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Category;
use App\Models\Supplier;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class ProductEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        $product = $this->query->get('product');

        return [
            Input::make('id')
                ->hidden()
                ->value($product->id ?? ""),

            Input::make('name')
                ->title('Tên sản phẩm')
                ->required()
                ->value($product->name ?? ""),

            Input::make('ingredient')
                ->title('Thành phần')
                ->required()
                ->value($product->ingredient ?? ""),

            Select::make('category_id')
                ->title('Danh mục')
                ->required()
                ->fromModel(Category::class, 'name'),

            Select::make('supplier_id')
                ->title('Nhà cung cấp')
                ->required()
                ->fromModel(Supplier::class, 'name'),

            Input::make('total')
                ->title('Tổng số lượng')
                ->required()
                ->value($product->total ?? 0),

        ];
    }
}
