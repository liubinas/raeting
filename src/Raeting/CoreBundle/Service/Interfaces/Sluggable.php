<?php

namespace Raeting\CoreBundle\Service\Interfaces;

interface Sluggable
{
    public function getBySlug($slug);
}