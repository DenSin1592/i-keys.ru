<?php


namespace App\Models\Features;


trait SvgPath
{
    public function getSpriteSvgHtml(string $attributes = '', int $count = 1): string
    {
        if(is_null($this->svg_path)){
            return '';
        }

        $svgHtml = '';

        for($i = 1; $i <= $count; $i++){
            $svgHtml .= '<svg '. $attributes .' ><use xlink:href="'.asset($this->svg_path).'"></use></svg>';
        }

        return $svgHtml;
    }
}
