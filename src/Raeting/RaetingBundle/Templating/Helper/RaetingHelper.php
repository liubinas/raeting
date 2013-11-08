<?php

namespace Raeting\RaetingBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class RaetingHelper extends Helper
{

    public function __construct()
    {
    }

    public function renderPrice($price, $symbol)
    {
        return number_format($price, $symbol->getViewPrecision());
    }
    
    public function renderDate($date)
    {
        return date('D, M j, Y, g:iA', strtotime($date)).' UTC';
    }
    
    public function renderAnalysisStatus($status, $color = false)
    {
        switch($status){
            case 'buy':
                $status = 'buy';
                break;
            case 'sell':
            case 'overweight':
                $status = 'sell';
                break;
            case 'hold':
                $status = 'hold';
                break;
        }
        if($color){
            $label = null;
            switch($status){
                case 'buy': $label =  'label-success';break;
                case 'sell': $label =  'label-danger';break;
                case 'hold': $label =  'label-warning';break;
            }
            if($label != null){
                $status = '<span class="label '.$label.'">'.$status.'</span>';
            }
        }
        return $status;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'raeting';
    }    
}