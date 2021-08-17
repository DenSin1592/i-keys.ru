<?php namespace App\Services\Catalog\Filter\LensWrappers;

use App\Services\Catalog\Filter\Lens\LensInterface;

/**
 * Class AuthLensWrapper
 * Lens which hide variants of lens for unauthorized user.
 * @package App\Services\Catalog\Filter\LensWrapper
 */
class AuthLensWrapper implements LensInterface
{
    /**
     * @var LensInterface
     */
    private $lens;

    /**
     * @var bool|false
     */
    private $authorized;


    /**
     * AuthWrapperLens constructor.
     * @param LensInterface $lens
     * @param bool|false $authorized
     */
    public function __construct(LensInterface $lens, bool $authorized = false)
    {
        $this->lens = $lens;
        $this->authorized = $authorized;
    }

    public function modifyQuery($query, $lensData)
    {
        $this->lens->modifyQuery($query, $lensData);
    }

    public function getVariants($query, $restrictedQuery, $lensData)
    {
        if (!isset($lensData) && !$this->authorized) {
            return null;
        } else {
            return $this->lens->getVariants($query, $restrictedQuery, $lensData);
        }
    }

    public function cleanLensData($query, $lensData)
    {
        return $this->lens->cleanLensData($query, $lensData);
    }

    public function compareLensData($lensDataAlpha, $lensDataOmega)
    {
        return $this->lens->compareLensData($lensDataAlpha, $lensDataOmega);
    }
}
