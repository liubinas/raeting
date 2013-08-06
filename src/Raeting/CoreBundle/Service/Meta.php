<?php

namespace Raeting\CoreBundle\Service;

use Raeting\CoreBundle\Model\Meta as MetaModel;
use Symfony\Component\HttpFoundation\Request;
use RuntimeException;

class Meta{

    /**
     * @var Raeting\CoreBundle\Model\Meta
     */
    protected $model;

    /**
     * @param Raeting\CoreBundle\Model\Meta   $model
     */
    public function __construct(MetaModel $model)
    {
        $this->model = $model;
    }

    public function save(array $data)
    {
        if (empty($data['slug'])) {
            throw new RuntimeException('Slug is required attribute');
        }

        $item = $this->getMetaBySlug($data['slug']);
        if ($item) {
            $res = $this->model->update($data, array('slug' => $data['slug']));
        } else {
            $res = $this->model->insert($data);
        }

        return $res;
    }

    /**
     * @param  string $slug
     * @return array       
     */
    public function getMetaBySlug($slug)
    {
        return $this->model->getBySlug($slug);
    }

    /**
     * @param string $field meta field name
     * @param Symfony\Component\HttpFoundation\Request $request 
     * @return string
     */
    public function getValueByFieldAndRequest($field, $request) 
    {
        $slug = $this->getSlugFromRequest($request);
        $data = $this->getMetaBySlug($slug);

        if (!empty($data)) {
            if (!isset($data[$field])) {
                throw new RuntimeException(sprintf('Field %s does not exist in meta data table', $field));
            }

            return $data[$field];
        }
    }

    /**
     * @param Symfony\Component\HttpFoundation\Request          $request 
     */
    public function getSlugFromRequest(Request $request)
    {
        $uri = parse_url($request->getUri());
        unset($uri['query']);
        $uri = explode('/', $uri['path']);

        $parts = array();

        if (isset($uri[1])) {
            $parts[] = $uri[1];
        }
        if (isset($uri[2])) {
            $parts[] = $uri[2];
            if( in_array('store', $uri) ){
                $parts[] = $uri[3];
                $slug = '/' . implode('/', $parts);
            }
        }
        if (isset($uri[3])) {
            $parts[] = $uri[3];
        }
        if (isset($uri[4])) {
            $parts[] = $uri[4];
        }


        if(!isset($slug)){
            $slug = '/' . implode('/', $parts);
        }
        
        return $slug;
    }

    /**
     * @param Symfony\Component\HttpFoundation\Request          $request 
     */
    public function getPageNumberFromRequest(Request $request)
    {
        $uri = parse_url($request->getUri());
        unset($uri['query']);
        $uri = explode('/', $uri['path']);
        
        $page = null;
        if (isset($uri[2])) {
            $parts[] = $uri[2];
            if( in_array('store', $uri) ){
                if(isset($uri[4])){
                    $page = $uri[4];
                }
            }
        }

        return $page;        
    }

    /**
     * @param string $field meta field name
     * @param Symfony\Component\HttpFoundation\Request $request 
     * @return string
     */
    public function getDefaultValueByFieldAndRequest($field, $request)
    {

        $uri = explode('/', $request->getUri());
        $parts = array();

        $parts[] = $uri[3]; 
        $parts[] = 'default';
        $slug = '/' . implode('/', $parts);

        $data = $this->getMetaBySlug($slug);
        if (!empty($data)) {
            if (!isset($data[$field])) {
                throw new RuntimeException(sprintf('Field %s does not exist in meta data table', $field));
            }

            return $data[$field];
        } 
    }

}
