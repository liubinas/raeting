<?php

namespace Raeting\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RaetingUserBundle extends Bundle
{
    public function getParent()
    {
        return 'EstinaCMFUserBundle';
    }
}
