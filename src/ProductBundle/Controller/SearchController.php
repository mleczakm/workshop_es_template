<?php

namespace ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{

    public function test1Action()
    {
        $results = $this->get('elastica_search_service')->test1();

        return $this->renderCustomView($results);
    }

    public function test2Action()
    {
        $results = $this->get('elastica_search_service')->test2();

        return $this->renderCustomView($results);
    }

    public function test3Action()
    {
        $results = $this->get('elastica_search_service')->test3();

        return $this->renderCustomView($results);
    }

    public function test4Action()
    {
        $results = $this->get('elastica_search_service')->test4();

        return $this->renderCustomView($results);
    }

    public function test5Action()
    {
        $results = $this->get('elastica_search_service')->test5();

        return $this->renderCustomView($results);
    }

    public function test6Action()
    {
        $results = $this->get('elastica_search_service')->test6();

        return $this->renderCustomView($results);
    }

    public function test7Action()
    {
        $results = $this->get('elastica_search_service')->test7();

        return $this->renderCustomView($results);
    }

    private function renderCustomView($data)
    {
        return $this->render(':search:index.html.twig', [
            'results' => $data
        ]);
    }

}