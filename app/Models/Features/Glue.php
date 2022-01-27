<?php

namespace App\Models\Features;

trait Glue
{
    use \Diol\FileclipExif\Glue;

    public function getImgPath(string $field, ?string $version, string $noImageVersion)
    {
        $attachment = $this->getAttachment($field);

        if($attachment?->exists($version))
            return asset($attachment->getUrl($version));
        return asset('/images/common/no-image/' . $noImageVersion);
    }

    public function getImgSourcePath(string $field, ?string $version, string $noImageVersion)
    {
        $attachment = $this->getAttachment($field);

        if($attachment?->exists())
            return asset($attachment->getRelativePath());
        return asset('/images/common/no-image/' . $noImageVersion);
    }
}
