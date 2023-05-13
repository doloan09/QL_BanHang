<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),

            TD::make('name', 'Tên danh mục'),

            TD::make('slug', 'Slug'),

            TD::make(__('Thao tác'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Category $category) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        ModalToggle::make('Sửa')
                            ->icon('pencil')
                            ->set('style', 'color: blue')
                            ->modal('asyncEditModal')
                            ->modalTitle('Danh mục')
                            ->method('save')
                            ->asyncParameters([
                                'group' => $category->id,
                            ]),

                        Button::make('Xóa')
                            ->set('style', 'color: red')
                            ->confirm('Bạn có muốn xóa không!')
                            ->method('delete', ['id' => $category->id])
                            ->icon('trash'),
                    ])),

        ];
    }
}
