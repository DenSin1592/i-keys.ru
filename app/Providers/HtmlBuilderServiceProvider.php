<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HtmlBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $optionStack = [];

        \Html::macro(
            'additionalMenuOpen',
            function (array $options) use (&$optionStack) {
                array_push($optionStack, $options);

                $attrArray = [];
                $resizeOpt = 'resize-menu-' . \Arr::get($options, 'resize');
                if (!is_null($resizeOpt)) {
                    $resizeWidth = \Arr::get($_COOKIE, $resizeOpt);
                    if (!is_null($resizeWidth)) {
                        $attrArray[] = "style='width: {$resizeWidth}px'";
                    }

                    $attrArray[] = "data-menu-resize='{$resizeOpt}'";
                }

                $attrString = implode(' ', $attrArray);

                return "<div class='menu-column additional-menu' {$attrString}>";
            }
        );

        \Html::macro(
            'additionalMenuClose',
            function () use (&$optionStack) {
                $options = array_pop($optionStack);
                $ret = '</div>';

                if (!is_null(\Arr::get($options, 'resize'))) {
                    $ret .= '<div class="menu-column additional-menu-resize"></div>';
                }

                return $ret;
            }
        );
    }
}
