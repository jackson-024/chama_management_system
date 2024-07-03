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
            <div class="my-4">
                <label for="%s" class="block text-sm font-medium leading-6 text-gray-900">%s</label>
                <div class="relative mt-2 rounded-md shadow-sm ">
                    <input type="%s" name="%s" id="%s" value="%s" class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 ring-1 ring-inset ring-gray-500 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 %s">
                </div>

                <div class="text-red-500">
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
            <div class="my-4">
                <label for="%s" class="block text-sm font-medium leading-6 text-gray-900">%s</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <select name="%s" id="%s" class="block w-full rounded-md border-0 py-1.5 pl-3 text-gray-900 ring-1 ring-inset ring-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 %s">
                        %s
                    </select>
                </div>

                <div class="text-red-500">
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

    public function selectField(array $options)
    {
        $this->type = self::TYPE_SELECT;
        $this->options = $options;
        return $this;
    }
}
