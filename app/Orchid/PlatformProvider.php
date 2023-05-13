<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),

            Menu::make(__('Danh mục'))
                ->icon('layers')
                ->route('categories.index')
                ->permission('platform.systems.categories'),

            Menu::make(__('Colors'))
                ->icon('target')
                ->route('colors.index')
                ->permission('platform.systems.colors'),

            Menu::make(__('Sizes'))
                ->icon('plus')
                ->route('sizes.index')
                ->permission('platform.systems.sizes'),

            Menu::make(__('Nhà cung cấp'))
                ->icon('server')
                ->route('suppliers.index')
                ->permission('platform.systems.suppliers'),

            Menu::make(__('Sản phẩm'))
                ->icon('module')
                ->route('products.index')
                ->permission('platform.systems.products'),

            Menu::make(__('Đơn hàng'))
                ->icon('basket-loaded')
                ->list([
                    Menu::make(__('Đơn hàng nhập'))
                        ->icon('list')
                        ->route('import_orders.index')
                        ->permission('platform.systems.orders'),

                    Menu::make(__('Đơn hàng bán'))
                        ->icon('layers')
                        ->route('sales_orders.index')
                        ->permission('platform.systems.orders'),

                ])
                ->permission('platform.systems.orders'),

        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users'))
                ->addPermission('platform.systems.colors', __('Colors'))
                ->addPermission('platform.systems.sizes', __('Sizes'))
                ->addPermission('platform.systems.suppliers', __('Suppliers'))
                ->addPermission('platform.systems.products', __('Products'))
                ->addPermission('platform.systems.orders', __('Orders'))
                ->addPermission('platform.systems.categories', __('Categories')),

        ];
    }
}
