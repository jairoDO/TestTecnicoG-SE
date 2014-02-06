<?php
namespace Kitpages\DataGridBundle\Tests\Model;

use Kitpages\DataGridBundle\Model\Field;
use Kitpages\DataGridBundle\Model\PaginatorConfig;
use Kitpages\DataGridBundle\Model\GridConfig;
use Kitpages\DataGridBundle\Service\GridManager;
use Kitpages\DataGridBundle\Tests\BundleOrmTestCase;


class GridManagerTest extends BundleOrmTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testPaginator()
    {
        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("node");

        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $request = new \Symfony\Component\HttpFoundation\Request();
        $_SERVER["REQUEST_URI"] = "/foo";

        // create gridManager instance
        $gridManager = new GridManager($service);

        // configure paginator
        $paginatorConfig = new PaginatorConfig();
        $paginatorConfig->setCountFieldName("node.id");
        $paginatorConfig->setItemCountInPage(3);

        // get paginator
        $paginator = $gridManager->getPaginator($queryBuilder, $paginatorConfig, $request);

        // tests
        $this->assertEquals(11, $paginator->getTotalItemCount());

        $this->assertEquals(4, $paginator->getTotalPageCount());

        $this->assertEquals(array(1,2,3,4), $paginator->getPageRange());

        $this->assertEquals(1 , $paginator->getCurrentPage());
        $this->assertEquals(2, $paginator->getNextButtonPage());
    }

    public function testPaginatorGroupBy()
    {
        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("node.user, count(node.id) as cnt");
        $queryBuilder->groupBy("node.user");

        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $request = new \Symfony\Component\HttpFoundation\Request();
        $_SERVER["REQUEST_URI"] = "/foo";

        // create gridManager instance
        $gridManager = new GridManager($service);

        // configure paginator
        $paginatorConfig = new PaginatorConfig();
        $paginatorConfig->setCountFieldName("node.user");
        $paginatorConfig->setItemCountInPage(3);

        // get paginator
        $paginator = $gridManager->getPaginator($queryBuilder, $paginatorConfig, $request);

        // tests
        $this->assertEquals(6, $paginator->getTotalItemCount());

        $this->assertEquals(2, $paginator->getTotalPageCount());

        $this->assertEquals(array(1,2), $paginator->getPageRange());

        $this->assertEquals(1 , $paginator->getCurrentPage());
        $this->assertEquals(2, $paginator->getNextButtonPage());
    }

    public function initGridConfig()
    {
        // configure paginator
        $paginatorConfig = new PaginatorConfig();
        $paginatorConfig->setCountFieldName("node.id");
        $paginatorConfig->setItemCountInPage(3);

        $gridConfig = new GridConfig();
        $gridConfig->setPaginatorConfig($paginatorConfig);
        $gridConfig->setCountFieldName("node.id");
        $gridConfig
            ->addField(new Field("node.id"))
            ->addField(new Field("node.createdAt",
            array(
                "sortable"=>true,
                "formatValueCallback" => function ($value) { return $value->format("Y/m/d"); }
            )
        ));
        $gridConfig->addField(new Field("node.content",
            array(
                "formatValueCallback" => function ($value, $row) { return $value.":".$row["createdAt"]->format("Y"); }
            )
        ));
        $gridConfig->addField(new Field("node.user", array(
            "filterable"=> true
        )));
        return $gridConfig;
    }


    public function testGridBasic()
    {
        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $_SERVER["REQUEST_URI"] = "/foo";
        $request = new \Symfony\Component\HttpFoundation\Request();
        // create gridManager instance
        $gridManager = new GridManager($service);

        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("node");

        $gridConfig = new GridConfig();
        $gridConfig->setCountFieldName("node.id");
        $gridConfig->addField(new Field("node.createdAt",
            array(
                "sortable"=>true,
                "formatValueCallback" => function ($value) { return $value->format("Y/m/d"); }
            )
        ));
        $gridConfig->addField(new Field("node.content",
            array(
                "formatValueCallback" => function ($value, $row) { return $value.":".$row["createdAt"]->format("Y"); }
            )
        ));

        // get paginator
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $paginator = $grid->getPaginator();

        // tests paginator
        $this->assertEquals(11, $paginator->getTotalItemCount());

        // grid test
        $itemList = $grid->getItemList();
        $this->assertEquals( 11 , count($itemList));
        $this->assertEquals( 1 , $itemList[0]["id"]);
        // simple callback
        $this->assertEquals( "2010/04/24" , $grid->displayGridValue($itemList[0], $gridConfig->getFieldByName("node.createdAt")));
        $this->assertEquals( "foobar:2010" , $grid->displayGridValue($itemList[0], $gridConfig->getFieldByName("node.content")));
    }

    public function testGridRelation()
    {
        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->query->set("kitdg_paginator_paginator_currentPage", 2);
        // create gridManager instance
        $gridManager = new GridManager($service);

        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("node, node.id*2 as doubleId");

        $gridConfig = $this->initGridConfig();
        $gridConfig->addField(new Field("doubleId"));

        // get paginator
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $paginator = $grid->getPaginator();

        // tests paginator
        $this->assertEquals(11, $paginator->getTotalItemCount());

        // grid test
        $itemList = $grid->getItemList();
        $this->assertEquals( 3 , count($itemList));
        $this->assertEquals( "paginator", $paginator->getPaginatorConfig()->getName());
        $this->assertEquals( 2, $paginator->getCurrentPage() );
        $this->assertEquals( 1, $paginator->getPreviousButtonPage());
        $this->assertEquals( 3, $paginator->getNextButtonPage());
        $this->assertEquals( 10 , $itemList[1]["doubleId"]);
        // simple callback
    }

    /*
     * Test added following this issue : https://github.com/kitpages/KitpagesDataGridBundle/issues/18
     * But I can't reproduce that bug...
     * TODO: go back here later and reproduce this issue...
     */
    public function testGridLeftJoin()
    {
        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->query->set("kitdg_paginator_paginator_currentPage", 2);
        // create gridManager instance
        $gridManager = new GridManager($service);

        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("DISTINCT(node.id), node, count(sn.id) as intervals")
            ->leftJoin('node.subNodeList', 'sn')
            ->groupBy('node.id')
            ->orderBy('node.id', 'ASC');

        $gridConfig = $this->initGridConfig();
        $gridConfig->addField(new Field("doubleId"));

        // get paginator
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $paginator = $grid->getPaginator();

        // tests paginator
        $this->assertEquals(11, $paginator->getTotalItemCount());

        // grid test
        $itemList = $grid->getItemList();
        $this->assertEquals( 3 , count($itemList));
        $this->assertEquals( "paginator", $paginator->getPaginatorConfig()->getName());
        $this->assertEquals( 2, $paginator->getCurrentPage() );
        $this->assertEquals( 1, $paginator->getPreviousButtonPage());
        $this->assertEquals( 3, $paginator->getNextButtonPage());
        // simple callback
    }
    /*
     *
     */
    public function testGridLeftJoinWithoutGroupBy()
    {
        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $request = new \Symfony\Component\HttpFoundation\Request();
        // create gridManager instance
        $gridManager = new GridManager($service);

        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("node", "mainNode")
            ->leftJoin('node.mainNode', 'mainNode');

        $gridConfig = $this->initGridConfig();
        $nodeIdField = new Field("node.id");
        $gridConfig->addField($nodeIdField);
        $mainNodeIdField = new Field("node.mainNode.id");
        $gridConfig->addField($mainNodeIdField);

        // get paginator
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $paginator = $grid->getPaginator();

        // tests paginator
        $this->assertEquals(11, $paginator->getTotalItemCount());

        // grid test
        $itemList = $grid->getItemList();
        $this->assertEquals( 3 , count($itemList));

        $cnt = 0;
        foreach($itemList as $item) {
//            var_dump($item);
            $cnt ++;
            $nodeId = $grid->displayGridValue($item, $nodeIdField);
            $this->assertEquals($cnt, $nodeId);
            try {
                $mainNodeId = $grid->displayGridValue($item, $mainNodeIdField);
                if ($cnt == 1) {
                    $this->fail("node 1 should not have a parentId");
                } else {
                    $this->assertEquals($mainNodeId, 1);
                }
            } catch (\Exception $e) {
                $this->assertEquals($cnt, 1);
            }
        }

        $mainNodeIdField->setNullIfNotExists(true);
        $cnt = 0;
        foreach($itemList as $item) {
            $cnt ++;
            $nodeId = $grid->displayGridValue($item, $nodeIdField);
            $this->assertEquals($cnt, $nodeId);
            $mainNodeId = $grid->displayGridValue($item, $mainNodeIdField);
            if ($cnt == 1) {
                $this->assertTrue(is_null($mainNodeId));
            } else {
                $this->assertEquals(1, $mainNodeId);
            }
        }
    }

    public function testGridFilter()
    {
        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->query->set("kitdg_grid_grid_filter", "foouser");
        $request->query->set("kitdg_grid_grid_sort_field", "node.createdAt");
        $request->query->set("kitdg_paginator_paginator_currentPage", 2);
        // create gridManager instance
        $gridManager = new GridManager($service);

        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("node");

        $gridConfig = $this->initGridConfig();

        // get paginator
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $paginator = $grid->getPaginator();

        // tests paginator
        $this->assertEquals(2, $paginator->getTotalItemCount());

        // grid test
        $itemList = $grid->getItemList();
        $this->assertEquals( 2 , count($itemList));
        $this->assertEquals( 8 , $itemList[0]["id"]);
        $this->assertEquals( 1 , $paginator->getCurrentPage());

        $request->query->set("kitdg_grid_grid_sort_field", "node.user");
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $itemList = $grid->getItemList();
        $this->assertEquals( 6 , $itemList[0]["id"]);

        $request->query->set("kitdg_grid_grid_filter", "foo");
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $itemList = $grid->getItemList();
        $this->assertEquals( 3 , count($itemList));

    }

    public function testGridUtf8Filter()
    {
        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->query->set("kitdg_grid_grid_filter", "foouser");
        $request->query->set("kitdg_grid_grid_sort_field", "node.createdAt");
        $request->query->set("kitdg_paginator_paginator_currentPage", 2);
        // create gridManager instance
        $gridManager = new GridManager($service);

        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("node");

        $gridConfig = $this->initGridConfig();

        // get paginator
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $paginator = $grid->getPaginator();

        // tests paginator
        $this->assertEquals(2, $paginator->getTotalItemCount());

        // grid test
        $itemList = $grid->getItemList();
        $this->assertEquals( 2 , count($itemList));
        $this->assertEquals( 8 , $itemList[0]["id"]);
        $this->assertEquals( 1 , $paginator->getCurrentPage());

        $request->query->set("kitdg_grid_grid_filter", "fös");
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $itemList = $grid->getItemList();
        $this->assertEquals( 1 , count($itemList));

    }

    public function testGridSelector()
    {
        // create EventDispatcher mock
        $service = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcher');
        // create Request mock (ok this is not a mock....)
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->query->set("kitdg_grid_grid_selector_field", "node.user");
        $request->query->set("kitdg_grid_grid_selector_value", "foouser");
        $request->query->set("kitdg_grid_grid_sort_field", "node.createdAt");
        $request->query->set("kitdg_paginator_paginator_currentPage", 2);
        // create gridManager instance
        $gridManager = new GridManager($service);

        // create queryBuilder
        $em = $this->getEntityManager();
        $repository = $em->getRepository('Kitpages\DataGridBundle\Tests\TestEntities\Node');
        $queryBuilder = $repository->createQueryBuilder("node");
        $queryBuilder->select("node");

        $gridConfig = $this->initGridConfig();

        // get paginator
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $paginator = $grid->getPaginator();

        // tests paginator
        $this->assertEquals(2, $paginator->getTotalItemCount());

        // grid test
        $itemList = $grid->getItemList();
        $this->assertEquals( 2 , count($itemList));
        $this->assertEquals( 8 , $itemList[0]["id"]);
        $this->assertEquals( 1 , $paginator->getCurrentPage());

        $request->query->set("kitdg_grid_grid_sort_field", "node.user");
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $itemList = $grid->getItemList();
        $this->assertEquals( 6 , $itemList[0]["id"]);

        $request->query->set("kitdg_grid_grid_selector_value", "5");
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $request);
        $itemList = $grid->getItemList();
        $this->assertEquals( 0 , count($itemList));

    }

}
