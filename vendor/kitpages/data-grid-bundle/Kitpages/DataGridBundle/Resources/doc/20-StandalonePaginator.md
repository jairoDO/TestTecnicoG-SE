Standalone Paginator
====================

You can use the paginator as a standalone component.

In your controller

    use Kitpages\DataGridBundle\Model\PaginatorConfig;
    [...]

    public function gridAction()
    {
        $gridManater = $this->get("kitpages_data_grid.manager");

        $repository = $this->getDoctrine()->getRepository('KitpagesShopBundle:OrderLine');
        $queryBuilder = $repository->createQueryBuilder("ol");
        $queryBuilder->select("ol");

        $paginatorConfig = new PaginatorConfig();
        $paginatorConfig->setCountFieldName("ol.id");
        $paginator = $gridManater->getPaginator($queryBuilder, $paginatorConfig, $this->getRequest());
        return $this->render('AppSiteBundle:Default:paginator.html.twig', array(
            "paginator" => $paginator
        ));
    }

In your twig :

    {% embed 'KitpagesDataGridBundle:Paginator:paginator.html.twig' with {'paginator': paginator} %}
    {% endembed %}

