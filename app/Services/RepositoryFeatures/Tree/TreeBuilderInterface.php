<?php namespace App\Services\RepositoryFeatures\Tree;

/**
 * Interface TreeBuilderInterface
 * Interface for tree builder.
 *
 * @package App\Services\RepositoryFeatures\Tree
 */
interface TreeBuilderInterface
{
    /**
     * Get tree.
     *
     * @param \Eloquent $modelTemplate
     * @param $parentId
     * @param callable $filterCallback
     * @return mixed
     */
    public function getTree(\Eloquent $modelTemplate, $parentId = null, callable $filterCallback = null);

    /**
     * Get path to tree - list of objects.
     * @param \Eloquent $modelTemplate
     * @param $id
     * @return mixed
     */
    public function getTreePath(\Eloquent $modelTemplate, $id);

    /**
     * Get collapsed tree - useful for menu.
     *
     * @param \Eloquent $modelTemplate
     * @param null $id
     * @return mixed
     */
    public function getCollapsedTree(\Eloquent $modelTemplate, $id = null);

    /**
     * Get hierarchical variants (for select, for example).
     * @param \Eloquent $modelTemplate
     * @param $currentId
     * @param null $root
     * @return mixed
     */
    public function getTreeVariants(\Eloquent $modelTemplate, $currentId, $root = null);

    /**
     * Change query to select rooted element.
     *
     * @param $query
     * @return mixed
     */
    public function scopeRooted($query);

    /**
     * Change query to select elements inside of some element.
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeChildOf($query, $id);

    /**
     * List of ids inside of this model.
     *
     * @param \Eloquent $modelTemplate
     * @param null $rootId
     * @return array
     */
    public function getChildIds(\Eloquent $modelTemplate, $rootId = null);

    /**
     * List of parent ids for this model.
     *
     * @param \Eloquent $modelTemplate
     * @param $id
     * @return mixed
     */
    public function getParentIds(\Eloquent $modelTemplate, $id);

    /**
     * Get root for model.
     *
     * @param \Eloquent $modelTemplate
     * @param $id
     * @return \Eloquent
     */
    public function getRoot(\Eloquent $modelTemplate, $id);
}
