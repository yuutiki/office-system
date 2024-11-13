<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

class Icon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected string $name,
        protected string $class = '',
        protected int $width = 24,
        protected int $height = 24
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string
    {
        $svgPath = $this->resolveSvgPath();
        
        if (!file_exists($svgPath)) {
            return '';
        }
        
        $svg = str_replace(
            ['<svg', 'width="24"', 'height="24"'],
            [
                sprintf('<svg class="%s"', $this->class),
                sprintf('width="%d"', $this->width),
                sprintf('height="%d"', $this->height)
            ],
            file_get_contents($svgPath)
        );
        
        // 文字列として直接返すか、ビューにデータを渡す
        return $svg;
        // または
        // return view('components.icon', ['svg' => $svg]);
    }

    protected function resolveSvgPath(): string
    {
        if (Str::contains($this->name, '/')) {
            return resource_path("svg/{$this->name}.svg");
        }
        
        $categories = ['ui', 'social', 'brand'];
        
        foreach ($categories as $category) {
            $path = resource_path("svg/{$category}/{$this->name}.svg");
            if (file_exists($path)) {
                return $path;
            }
        }
        
        return resource_path("svg/{$this->name}.svg");
    }
}