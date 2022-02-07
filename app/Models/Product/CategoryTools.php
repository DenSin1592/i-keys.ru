<?php

namespace App\Models\Product;

use App\Models\Category;


trait CategoryTools
{

    public function isCylinder(): bool
    {
        $categoryPath = $this->category->extractPath();
        return $categoryPath[0]->code_1c === Category::CILINDRY_1C_CODE;
    }


    public function isLock(): bool
    {
        $categoryPath = $this->category->extractPath();
        return $categoryPath[0]->id === Category::LOCKS_ID;
    }


    public function isArmorplate(): bool
    {
        return false;
    }


    public function isDoorHandle(): bool
    {
        $categoryPath = $this->category->extractPath();
        return $categoryPath[0]->id === Category::DOOR_HANDLES_ID;
    }


    public function isFindings(): bool
    {
        $categoryPath = $this->category->extractPath();
        return $categoryPath[0]->id === Category::FINDINGS_ID;
    }
}
