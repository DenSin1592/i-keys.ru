<?php


namespace App\Models\Features;


trait SvgPath
{
    public function getSpriteSvgHtml(string $attributes = ''): string
    {
        return $this->svg_path
        ? '<svg '. $attributes .' ><use xlink:href="'.asset($this->svg_path).'"></use></svg>'
        : '';
    }
}
