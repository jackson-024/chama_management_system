<?php

namespace app\views\tables;

class Table
{
    public static function begin($name, $link = null, $linkText = null, $showDateRangeFilter = false)
    {
        echo sprintf('
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title">
                        <h1 class="title">%s</h1>
                    </div>
                    %s
                    %s
                </div>

                <div class="table-content">
                    <div class="table-scroll">
                        <div class="table-wrapper">
                            <div class="table-shadow">
                                <table class="table">
            ', $name, self::generateDateRangeFilterHtml($showDateRangeFilter), self::generateLinkHtml($link, $linkText));
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
                <div class="link-container">
                    <a href="%s" class="link">
                        %s
                    </a>
                </div>
                ', $link, $linkText);
        }
        return '';
    }

    private static function generateDateRangeFilterHtml($showDateRangeFilter)
    {
        if ($showDateRangeFilter) {
            return '
                    <form method="get" id="page-filter">
                        <div class="text-container">
                            <div class="">                            
                                <p>Start Date</p>
                                <label for="select_year_start" class="form-label">Year:</label>
                                <select id="select_year_start"></select>
                          
                                <label for="select_month_start" class="form-label">Month:</label>
                                <select id="select_month_start"></select>
  
                                <label for="select_day_start" class="form-label">Day:</label>
                                <select id="select_day_start"></select> 
                                <input id="start_date" disabled/>
                            </div>

                            <div class="">                            
                                <p>End Date</p>
                                <label for="select_year_end" class="form-label">Year:</label>
                                <select id="select_year_end"></select>
                          
                                <label for="select_month_end" class="form-label">Month:</label>
                                <select id="select_month_end"></select>
  
                                <label for="select_day_end" class="form-label">Day:</label>
                                <select id="select_day_end"></select>
                                <input id="end_date" disabled /> 
                            </div>
                        
                            <button type="submit" class="btn-approve">Filter</button>
                        </div>
                    </form>
            ';
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
