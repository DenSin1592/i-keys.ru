<?php namespace App\Providers;

use App\Models\Node;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Repositories\ServicePage\EloquentServicePageRepository;
use App\Services\StructureTypes\RepositoryAssociation;
use App\Services\StructureTypes\Type;
use App\Services\StructureTypes\TypeContainer;
use Illuminate\Support\ServiceProvider;
use App\Services\Repositories\HomePage\EloquentHomePageRepository;
use App\Services\Repositories\TextPage\EloquentTextPageRepository;
use App\Services\Repositories\MetaPage\EloquentMetaPageRepository;

class StructureTypesServiceProvider extends ServiceProvider
{
    const REPO_HOME_PAGE = 'home_page_repo';
    const REPO_TEXT_PAGE = 'text_page_repo';
    const REPO_ERROR_PAGE = 'error_page_repo';
    const REPO_SERVICE_LIST_PAGE = 'service_list_page_repo';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'structure_types.types',
            function () {
                $typeContainer = new TypeContainer(
                    $this->app->make(EloquentNodeRepository::class)
                );

                $typeContainer->addRepositoryAssociation(
                    self::REPO_HOME_PAGE,
                    new RepositoryAssociation(
                        $this->app->make(EloquentHomePageRepository::class),
                        function (Node $node) {
                            return route('cc.home-pages.edit', [$node->id]);
                        }
                    )
                );

                $typeContainer->addRepositoryAssociation(
                    self::REPO_TEXT_PAGE,
                    new RepositoryAssociation(
                        $this->app->make(EloquentTextPageRepository::class),
                        function (Node $node) {
                            return route('cc.text-pages.edit', [$node->id]);
                        }
                    )
                );

                $typeContainer->addRepositoryAssociation(
                    self::REPO_SERVICE_LIST_PAGE,
                    new RepositoryAssociation(
                        $this->app->make(EloquentServicePageRepository::class),
                        function (Node $node) {
                            return route('cc.service-pages.edit', [$node->id]);
                        }
                    )
                );

                /*$typeContainer->addRepositoryAssociation(
                    self::REPO_ERROR_PAGE,
                    new RepositoryAssociation(
                        $this->app->make(EloquentMetaPageRepository::class),
                        function (Node $node) {
                            return route('cc.meta-pages.edit', [$node->id]);
                        }
                    )
                );*/

                $typeContainer->addType(
                    Node::TYPE_HOME_PAGE,
                    new Type(
                        '?????????????? ????????????????',
                        true,
                        self::REPO_HOME_PAGE,
                        function () {
                            return route('home');
                        }
                    )
                );

                $typeContainer->addType(
                    Node::TYPE_SERVICES_PAGE,
                    new Type(
                        '???????????????? ??????????',
                        true,
                        self::REPO_SERVICE_LIST_PAGE,
                        function () {
                            return route('services');
                        }
                    )
                );

                $typeContainer->addType(
                    Node::TYPE_TEXT_PAGE,
                    new Type(
                        '?????????????????? ????????????????',
                        false,
                        self::REPO_TEXT_PAGE,
                        function (Node $node) {
                            return route('dynamic_page', implode('/', $node->getAliasPath()));
                        }
                    )
                );

               /* $typeContainer->addType(
                    Node::TYPE_ERROR_PAGE,
                    new Type(
                        '???????????????? 404',
                        true,
                        self::REPO_ERROR_PAGE,
                        function (Node $node) {
                            return '/page-not-found';
                        }
                    )
                );*/

                return $typeContainer;
            }
        );
    }
}
