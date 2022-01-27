<?php

namespace App\Models\Features;

trait Glue
{
    use \Diol\FileclipExif\Glue;

    public function getImgPath(string $field, ?string $version, string $noImageVersion)
    {
        if($this->getAttachment($field)?->exists($version))
            return asset($this->getAttachment($field)->getUrl($version));
        return asset('/images/common/no-image/' . $noImageVersion);
    }

    public function getImgSourcePath(string $field, ?string $version, string $noImageVersion)
    {
        if($this->getAttachment($field)?->exists())
            return asset($this->getAttachment($field)->getRelativePath());
        return asset('/images/common/no-image/' . $noImageVersion);
    }
}
