<?php

namespace Modules\Web\Traits;

trait HasSectionsTraits
{
    protected array $pageSections = [];

    public function setSections(array $sections): self
    {
        foreach ($sections as $view => $config) {
            $order = $config['order'] ?? 99;
            $data = $config['data'] ?? $config;

            $this->addSection($view, $data, $order);
        }

        return $this;
    }

    public function addSection(string $view, array $data = [], int $order = 99): self
    {
        $this->pageSections[] = [
            'view'  => $view,
            'data'  => $data,
            'order' => $order
        ];

        return $this;
    }

    public function getPageSections(): array
    {
        return collect($this->pageSections)->sortBy('order')->values()->all();
    }
}
