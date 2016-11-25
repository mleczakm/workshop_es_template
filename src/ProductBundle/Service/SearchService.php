<?php

namespace ProductBundle\Service;

use Elastica\Result;
use Elastica\ResultSet;
use Elastica\Script\Script;
use Elastica\SearchableInterface;
use Elastica\Query;
use Elastica\Query\BoolQuery;

class SearchService
{

    private $esShop;

    public function __construct(SearchableInterface $esShop)
    {
        $this->esShop = $esShop;
    }

    public function test1()
    {
    }

    public function test2()
    {
    }

    public function test3()
    {
    }

    public function test4()
    {
    }

    public function test5()
    {
    }

    public function test6()
    {
    }

    public function test7()
    {
    }

    private function getResult($resultSet)
    {
    }


}