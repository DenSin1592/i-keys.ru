<?php namespace App\Services\Seo;

/**
 * Class MetaHelper
 * @package App\Services\Seo
 */
class MetaHelper
{
    /**
     * @var MetaRule[]
     */
    private $ruleList = [];

    /**
     * Add rule.
     *
     * @param callable $rule
     * @param string $ruleKey
     */
    public function addRule(callable $rule, $ruleKey = 'default')
    {
        $this->ruleList[$ruleKey] = new MetaRule($rule);
    }


    /**
     * Get rule.
     *
     * @param string $ruleKey
     * @return MetaRule
     */
    public function getRule($ruleKey = 'default')
    {
        if (isset($this->ruleList[$ruleKey])) {
            $rule = $this->ruleList[$ruleKey];
        } else {
            $rule = new MetaRule(
                function ($metaData) {
                    return $metaData;
                }
            );
        }

        return $rule;
    }
}
