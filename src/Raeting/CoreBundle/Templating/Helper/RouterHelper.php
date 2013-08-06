<?php

/**
 * This file is part of Boozt Platform
 * and belongs to BZT Fashion AB.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Raeting\CoreBundle\Templating\Helper;

use Raeting\LocalizationBundle\Service\Localization;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper as BaseRouterHelper;

class RouterHelper extends BaseRouterHelper
{
    protected $generator;
    protected $localizationService;

    /**
     * Constructor.
     *
     * @param UrlGeneratorInterface $router       A Router instance
     * @param Localization          $localization Localization service.
     */
    public function __construct(UrlGeneratorInterface $router, Localization $localization)
    {
        $this->generator = $router;
        $this->localizationService = $localization;

        parent::__construct($router);
    }
}
