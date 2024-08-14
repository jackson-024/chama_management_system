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

    public function handleAction($key, $row)
    {
        if (is_callable($key)) {
            return call_user_func($key, $row);
        } else {
            return $key;
        }
    }

    public function __toString()
    {
        // check if data is empty
        if (empty($this->data)) {
            return '
                <tbody class="table-body">
                    <tr class="table-row">
                        <td class="table-cell no-data" colspan="100%">No data</td>
                    </tr>
                </tbody>
            ';
        }

        $tableData = '<tbody class="table-body">';

        foreach ($this->data as $row) {
            $tableData .= '<tr class="table-row">';

            foreach ($row as $key => $value) {
                $rowStyle = '';
                if (is_callable($this->rowStyles)) {
                    $rowStyle = call_user_func($this->rowStyles, [$key => $value]);
                }

                $tableData .= sprintf('
                    <td class="table-cell %s">
                        %s
                    </td>
                ', $rowStyle, $value);
            }

            if (count($this->actions) > 0) {
                foreach ($this->actions as $key) {
                    $tableData .= '<td class="table-cell">';
                    $tableData .= $this->handleAction($key, $row);
                    $tableData .= '</td>';
                }
            }

            $tableData .= '</tr>';
        }

        $tableData .= '</tbody>';

        return $tableData;
    }
}
