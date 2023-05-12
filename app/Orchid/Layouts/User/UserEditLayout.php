<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Input::make('user.address')
                ->type('text')
                ->title(__('Address'))
                ->placeholder(__('Address')),

            Input::make('user.phone')
                ->type('text')
                ->title(__('Phone'))
                ->placeholder(__('Phone')),

            DateTimer::make('user.date_of_birth')
                ->title('Ngày sinh'),

            Select::make('user.gender')
                ->options([
                    'nữ'   => 'nữ',
                    'nam' => 'nam',
                ])
                ->title('Giới tính'),

        ];
    }
}
