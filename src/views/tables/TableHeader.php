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
        if (!empty($this->properties[0])) {
            $headerHtml = '<thead class="table-head"><tr>';
            foreach (array_keys($this->properties[0]) as $key) {
                $headerHtml .= sprintf('
                <th scope="col" class="table-header-cell">
                    %s
                </th>
            ', str_replace("_", " ", $key));
            }
            if ($this->actions) {
                $headerHtml .= '
                <th scope="col" class="table-header-cell">
                    Actions
                </th>
            ';
            }
            $headerHtml .= '</tr></thead>';

            return $headerHtml;
        } else {
            $headerHtml = "";
            return $headerHtml;
        }
    }
}
