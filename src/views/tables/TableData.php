<?php

namespace app\views\tables;

class TableData
{
    public $data;
    public ?array $actions = [];
    public $rowStyles;

    public function __construct($data, $actions = [], $rowStyles = null)
    {
        $this->data = $data;
        $this->actions = $actions;
        $this->rowStyles = $rowStyles;
    }

    public function handleAction($key)
    {
        if (is_callable($key)) {
            return call_user_func($key, $this->data[0]);
        } else {
            return $key;
        }
    }

    public function __toString()
    {
        $tableData = '<tbody class="divide-y divide-gray-200 bg-white">';

        foreach ($this->data as $row) {
            $tableData .= '<tr>';

            foreach ($row as $key => $value) {
                $rowStyle = '';
                if (is_callable($this->rowStyles)) {
                    $rowStyle = call_user_func($this->rowStyles, [$key => $value]);
                }

                $tableData .= sprintf('
                    <td class="whitespace-nowrap py-2 px-3 text-sm text-gray-900 %s">
                        %s
                    </td>
                ', $rowStyle, $value);
            }

            if (count($this->actions) > 0) {
                foreach ($this->actions as $key) {
                    $tableData .= '<td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium">';
                    $tableData .= $this->handleAction($key);
                    $tableData .= '</td>';
                }
            }

            $tableData .= '</tr>';
        }

        $tableData .= '</tbody>';

        return $tableData;
    }
}
