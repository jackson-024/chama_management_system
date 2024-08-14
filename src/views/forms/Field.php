<?php

namespace app\views\forms;

use app\models\Model;

class Field
{

    public const TYPE_TEXT = "text";
    public const TYPE_EMAIL = "email";
    public const TYPE_PASSWORD = "password";
    public const TYPE_NUMBER = "number";
    public const TYPE_SELECT = "select";

    public string $type;
    public Model $model;
    public string $attribute;
    public array $options = []; // New property for select options

    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        if ($this->type === 'select') {
            return $this->renderSelectField();
        }

        return sprintf(
            '
           <div class="form-group">
                <label for="%s" class="form-label">%s</label>
                <div class="input-wrapper">
                    <input type="%s" name="%s" id="%s" value="%s" class="form-input %s">
                </div>
                <div class="error-message">
                    %s
                </div>
            </div>
        ',
            $this->attribute, //label Id
            $this->model->labels()[$this->attribute] ?? $this->attribute, // Label name
            $this->type, // input type
            $this->attribute, // input name
            $this->attribute, // input id
            $this->model->{$this->attribute}, // input value
            $this->model->hasError($this->attribute) ? 'border-2 border-red-500' : '',
            $this->model->getError($this->attribute),
        );
    }

    private function renderSelectField()
    {
        $optionsHtml = '';
        foreach ($this->options as $value => $label) {
            $selected = $this->model->{$this->attribute} == $value ? 'selected' : '';
            $optionsHtml .= sprintf('<option value="%s" %s>%s</option>', $value, $selected, $label);
        }

        return sprintf(
            '
           <div class="form-group">
                <label for="%s" class="form-label">%s</label>
                <div class="input-wrapper">
                    <select name="%s" id="%s" class="form-select %s">
                        %s
                    </select>
                </div>
                <div class="error-message">
                    %s
                </div>
            </div>
            ',
            $this->attribute, // label Id
            $this->model->labels()[$this->attribute] ?? $this->attribute, // Label name
            $this->attribute, // select name
            $this->attribute, // select id
            $this->model->hasError($this->attribute) ? 'border-2 border-red-500' : '',
            $optionsHtml, // options HTML
            $this->model->getError($this->attribute),
        );
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function emailField()
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function numberField()
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    public function dateField()
    {
        $this->type = "date";
        return $this;
    }

    public function timeField()
    {
        $this->type = "time";
        return $this;
    }

    public function selectField(array $options)
    {
        $this->type = self::TYPE_SELECT;
        $this->options = $options;
        return $this;
    }
}
