<?php

namespace App\View\Components\Components;

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Illuminate\Support\ViewErrorBag;

class Alert extends Component
{
    /** @var string $type */
    public $type;

    public function __construct(string $type = 'alert')
    {
        $this->type = $type;
    }

    public function render(): View
    {
        return view('components.components.alert');
    }

    public function messages(): array
    {
        $msg = session()->get($this->type);

        if (is_a($msg, ViewErrorBag::class)) {
            return $msg->all();
        }

        return (array) session()->get($this->type);
    }

    public function message(): string
    {
        return (string) Arr::first($this->messages());
    }

    public function exists(): bool
    {
        return session()->has($this->type) && !empty($this->messages());
    }
}
