<?php

namespace app\views\tables;

class Table
{
    public static function begin($name, $link = null, $linkText = null)
    {
        echo sprintf('
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="">
                        <h1 class="text-3xl font-semibold leading-6 text-gray-900">%s</h1>
                     </div>
                    %s
                </div>

                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                <table class="min-w-full bg-gray-200 divide-y divide-gray-300">    
        ', $name, self::generateLinkHtml($link, $linkText));
        return new self();
    }

    public static function end()
    {
        echo '
                    </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
    }

    private static function generateLinkHtml($link, $linkText)
    {
        if ($link && $linkText) {
            return sprintf('
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a href="%s" class="cursor-pointer block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        %s
                    </a>
                </div>
            ', $link, $linkText);
        }
        return '';
    }

    public static function TableHeader($properties, $actions = false)
    {
        return new TableHeader($properties, $actions);
    }

    public static function TableData($data, $actions, $rowStyles = null)
    {
        return new TableData($data, $actions, $rowStyles);
    }
}
