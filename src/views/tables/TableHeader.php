<?php

namespace app\views\tables;

class TableHeader
{
    public array $properties;
    public bool $actions = false;

    public function __construct(array $properties, bool $actions = false)
    {
        $this->properties = $properties;
        $this->actions = $actions;
    }

    public function __toString()
    {

        $headerHtml = '<thead class=""><tr>';
        foreach (array_keys($this->properties[0]) as $key) {
            $headerHtml .= sprintf('
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 capitalize">
                    %s
                </th>
            ', str_replace("_", " ", $key));
        }
        if ($this->actions) {
            $headerHtml .= '
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">
                    Actions
                </th>
            ';
        }
        $headerHtml .= '</tr></thead>';

        return $headerHtml;
    }
}
