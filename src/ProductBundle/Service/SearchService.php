<?php

namespace ProductBundle\Service;

use Elastica\Aggregation\Range;
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
        $result = $this->esShop
            ->search(new Query\Term(['price' => 50]))
            ->getResults();

        return $this->getResult($result);
    }

    public function test2()
    {
        $result = $this->esShop
            ->search(new Query\Terms('quantity', [1,2,3,4,5]))
            ->getResults();

        return $this->getResult($result);
    }

    public function test3()
    {
        $query = new Query\BoolQuery();
        $range = (new Query\Range())->addField(
            'price', [
                'gte' => 20,
                'lte' => 100,
            ]
        );

        $query->addMust($range);
        $query->addMust(new Query\Terms('quantity', [500,600]));

        $result = $this->esShop
            ->search($query)
            ->getResults();

        return $this->getResult($result);
    }

    public function test4()
    {
        $result = $this->esShop
            ->search(new Query\Terms('status_id.enabled', [true]))
            ->getResults();

        return $this->getResult($result);
    }

    public function test5()
    {
        $queryBool = new Query\BoolQuery();

        $queryBool->addMust(new Query\Terms('notes.note', [1]));
        $queryBool->addMust(new Query\Terms('notes.note_category_id', [1]));

        $nestedQuery = (new Query\Nested())
        ->setPath('notes')
        ->setQuery($queryBool);


        $result = $this->esShop
            ->search($nestedQuery)
            ->getResults();

        return $this->getResult($result);
    }

    public function test6()
    {
        $queryBool = new Query();

        $match = new Query\Match('description', 'salmi');

        $highlight = [
            'pre_tags' => ['<u>'],
            'post_tags' => ['</u>'],
            'fields' => [
                'description' => [
                    'fragment_size' => 200,
                    'number_of_fragments' => 2
                ]
            ]
        ];

        $queryBool->setHighlight($highlight);

        $queryBool->setQuery($match);

        $result = $this->esShop
            ->search($queryBool)
            ->getResults();

        return $this->getResult($result);
    }

    public function test7()
    {
        $queryBool = new Query();

        $range = (new Query\Range())
        ->addField('quantity', ['lte' => 20]);

        $script = new Script('price = doc[\'price\'].value; if(price>100) {return price * 5/100}; return price * 50/100');

        $functionScore = new Query\FunctionScore();
        $functionScore
            ->setQuery($range)
            ->addScriptScoreFunction($script);

        $queryBool->setQuery($functionScore);

        $result = $this->esShop
            ->search($queryBool)
            ->getResults();

        return $this->getResult($result);
    }

    /**
     * @param $resultSet
     * @return array
     */
    private function getResult($resultSet)
    {
        return array_map(function ($value) {
            /** @var $value Result */
            $source['id'] = $value->getId();
            $source['data'] = $value->getData();
            $source['score'] = $value->getScore();
            $source['highlights'] = $value->getHighlights();

            return $source;
        }, $resultSet);
    }


}