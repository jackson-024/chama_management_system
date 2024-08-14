<?php

namespace app\views\forms;

use app\models\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new self();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new Field($model, $attribute);
    }

    public static function button(string $name)
    {
        echo sprintf('
                <button type="submit" class="submit-button">
                    %s
                </button>
            ', $name);
    }
}
