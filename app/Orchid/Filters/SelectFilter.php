<?php

declare(strict_types=1);

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class SelectFilter extends Filter
{
    private string $fieldName;
    private string $title;
    private array $arr;

    public static function make(string $fieldName, string $title, array $arr): SelectFilter
    {
        return new self($fieldName, $title, $arr);
    }

    public function __construct(string $fieldName, string $title, array $arr)
    {
        parent::__construct();
        $this->fieldName  = $fieldName;
        $this->title = $title;
        $this->arr = $arr;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->title;
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return [$this->fieldName];
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where($this->fieldName, $this->request->input($this->fieldName));
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make($this->fieldName)
                ->options(array_reverse($this->arr, true))
                ->empty('Tất cả')
                ->value($this->request->input($this->fieldName))
                ->title($this->title),
        ];
    }
}
