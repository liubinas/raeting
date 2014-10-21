<?php

namespace Raeting\RaetingBundle\Templating\Helper;

use Raeting\RaetingBundle\Entity\Analysis;

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

    public function renderDate($date ,$type = 'full')
    {
        switch($type){
            case 'full':
                    return date('Y-m-d H:i:s', strtotime($date));
                break;
            case 'date':
                    return date('Y-m-d', strtotime($date));
                break;
            case 'hours':
                    return date('H:i:s', strtotime($date));
                break;
        }
    }

    public function getAnalysisStatus($status)
    {
        $status = trim($status);
        $status = strtolower($status);

        switch($status){
            case 'above average':
            case 'accumulate':
            case 'accumulate on weakness':
            case 'add':
            case 'arbitrage buy':
            case 'attractive':
            case 'buy for yield':
            case 'cover short':
            case 'decrease':
            case 'gradually accumulate':
            case 'high risk buy':
            case 'increase':
            case 'industry outperform':
            case 'long-term accumulate':
            case 'long-term attractive':
            case 'long-term market outperform':
            case 'long-term soft buy':
            case 'long-term speculative buy':
            case 'market outperform':
            case 'moderate outperform':
            case 'moderately attractive':
            case 'most attractive':
            case 'near-term accumulate':
            case 'near-term attractive':
            case 'own':
            case 'positive':
            case 'potential':
            case 'short-term accumulate':
            case 'short-term add':
            case 'short-term attractive':
            case 'short-term market outperform':
            case 'short-term soft buy':
            case 'short-term speculative buy':
            case 'short-term trading buy':
            case 'short-term weak buy':
            case 'soft buy':
            case 'speculative accumulate':
            case 'speculative buy':
            case 'speculative outperform':
            case 'speculative strong buy':
            case 'stag':
            case 'strong speculative buy':
            case 'undervalued':
            case 'value buy':
            case 'very attractive':
            case 'vulnerable':
            case 'weak buy':
            case 'weak long-term buy':
            case 'aggressive buy':
            case 'analyst action list':
            case 'analyst buy':
            case 'analysts select list':
            case 'approved list':
            case 'best ideas list':
            case 'buy':
            case 'buy (select list)':
            case 'buy 2':
            case 'buy 3':
            case 'buy on recovery':
            case 'buy on weakness':
            case 'buy-attractive':
            case 'buy/attractive':
            case 'buy-short term buy':
            case 'buy/cautious':
            case 'buy/negative':
            case 'buy/neutral':
            case 'buy/positive':
            case 'core holding':
            case 'emphasis list':
            case 'exemplary':
            case 'favorable':
            case 'featured international stock':
            case 'featured stock of the week':
            case 'featured US stock':
            case 'focus buy':
            case 'focus list':
            case 'focus 1 selection':
            case 'global focus stock':
            case 'high perform':
            case 'highlighted stock list':
            case 'industry significant outperform':
            case 'key buy':
            case 'Latin American recommend list':
            case 'long term investment':
            case 'long-term buy':
            case 'long-term outperform':
            case 'long-term overweight':
            case 'long-term positive':
            case 'long-term strong buy':
            case 'look to buy':
            case 'major buy':
            case 'medium-term buy':
            case 'model portfolio':
            case 'must own':
            case 'near-term buy':
            case 'near-term outperform':
            case 'near-term strong buy':
            case 'neutral-short term buy':
            case 'outperform':
            case 'outperform significantly':
            case 'outperform/attractive':
            case 'outperform/buy':
            case 'outperform/cautious':
            case 'outperform/neutral':
            case 'overweight':
            case 'overweight/attractive':
            case 'overweight/cautious':
            case 'overweight/in-line':
            case 'overweight/no rating':
            case 'overwt/negative':
            case 'overwt/neutral':
            case 'overwt/positive':
            case 'performer':
            case 'portfolio buy':
            case 'priority buy':
            case 'priority list':
            case 'private client portfolio':
            case 'recommend list':
            case 'sector outperform':
            case 'select list':
            case 'sell-short term buy':
            case 'short-term buy':
            case 'short-term outperform':
            case 'short-term overweight':
            case 'short-term strong buy':
            case 'significant outperform':
            case 'single best idea':
            case 'single best idea list':
            case 'single best idea select list':
            case 'small cap recommend list':
            case 'SoCAL list':
            case 'strong buy':
            case 'strong buy (select list)':
            case 'strong long-term buy':
            case 'strong medium-term buy':
            case 'strong outperform':
            case 'strong sector outperform':
            case 'strong trading buy':
            case 'subscribe':
            case 'top pick':
            case 'trading buy':
            case 'trading buy (select list)':
                $status = Analysis::RECOMMENDATION_BUY;
                break;
            case 'avoid':
            case 'buy-short term sell':
            case 'industry significant underperfor':
            case 'laggard':
            case 'long-term avoid':
            case 'long-term reduce':
            case 'long-term reduce/sell':
            case 'long-term sell':
            case 'long-term underperform':
            case 'long-term underweight':
            case 'long-term underweight':
            case 'medium-term reduce':
            case 'near-term avoid':
            case 'near-term reduce':
            case 'near-term reduce/sell':
            case 'near-term sell':
            case 'near-term underperform':
            case 'neutral-short term sell':
            case 'not own':
            case 'not subscribe':
            case 'overvalued':
            case 'sector underperform':
            case 'sell':
            case 'sell on rally':
            case 'sell on strength':
            case 'sell on weakness':
            case 'sell/attractive':
            case 'sell/cautious':
            case 'sell/negative':
            case 'sell/neutral':
            case 'sell/positive':
            case 'sell-short term sell':
            case 'short sell':
            case 'short-term avoid':
            case 'short-term reduce':
            case 'short-term sellsoese':
            case 'short-term take profits':
            case 'short-term underperform':
            case 'short-term underweight':
            case 'source of funds':
            case 'strong sector underperform':
            case 'strong sell':
            case 'strong underperform':
            case 'swap':
            case 'take profits':
            case 'terminal short':
            case 'trading sell':
            case 'trim':
            case 'underperform':
            case 'underperform significantly':
            case 'underperform/attract':
            case 'underperform/cautious':
            case 'underperform/neutral':
            case 'underperform/sell':
            case 'underweight':
            case 'underweight/attractive':
            case 'underweight/cautious':
            case 'underweight/in-line':
            case 'underweight/no rating':
            case 'underwt/negative':
            case 'underwt/neutral':
            case 'underwt/positive':
            case 'unfavorable':
            case 'below average':
            case 'cautious hold':
            case 'distribute':
            case 'fully valued':
            case 'hold/sell':
            case 'industry underperform':
            case 'lighten':
            case 'long-term market underperform':
            case 'long-term soft sell':
            case 'market underperform':
            case 'moderate underperformer':
            case 'negative':
            case 'reduce':
            case 'reduce 1':
            case 'reduce 2':
            case 'short-term market underperfor':
            case 'short-term soft sell':
            case 'short-term switch':
            case 'short-term unattractive':
            case 'speculative sell':
            case 'speculative underperform':
            case 'top slice':
            case 'trading':
            case 'unattractive':
            case 'weak hold':
            case 'weak sell':
            case 'dropped coverage':
                $status = Analysis::RECOMMENDATION_SELL;
                break;
            case 'average':
            case 'cautious buy':
            case 'comparable':
            case 'equal weight':
            case 'equal-weight/attractive':
            case 'equal-weight/cautious':
            case 'equal-weight/in-line':
            case 'equal-weight/no rating':
            case 'equalwt/negative':
            case 'equalwt/neutral':
            case 'equalwt/positive':
            case '3 m fairly valued':
            case 'fairly valued':
            case 'hold':
            case 'hold on weakness':
            case 'hold/buy':
            case 'hold/cautious':
            case 'hold/negative':
            case 'hold/neutral':
            case 'hold/positive':
            case 'hold/speculative buy':
            case 'industry perform':
            case 'inline':
            case 'in-line/attractive':
            case 'in-line/cautious':
            case 'in-line/neutral':
            case 'long-term hold':
            case 'long-term market perform':
            case 'long-term neutral':
            case 'maintain':
            case 'maintain position':
            case 'market neutral':
            case 'market perform':
            case 'market weight':
            case 'match':
            case 'match (-)':
            case 'Match (+)':
            case 'medium-term neutral':
            case 'near-term hold':
            case 'near-term market perform':
            case 'near-term neutral':
            case 'neutral':
            case 'neutral 1':
            case 'neutral 2':
            case 'neutral minus':
            case 'neutral perform':
            case 'neutral plus':
            case 'neutral weight':
            case 'neutral/attractive':
            case 'neutral/cautious':
            case 'neutral/neutral':
            case 'no action':
            case 'peerperform':
            case 'perform in line':
            case 'range trading':
            case 'sector perform':
            case 'short-term hold':
            case 'short-term market perform':
            case 'short-term neutral':
            case 'speculative hold':
            case 'speculative neutral':
            case 'stagnant':
            case 'strong hold':
            case 'trading hold':
            case 'wait':
            case 'watch list':
            case 'equalweight':
            case 'under review':
                $status = Analysis::RECOMMENDATION_HOLD;
                break;
            default:
                throw new \Exception('Unknown recommendation: ' . $status);
                break;
        }

        return $status;
    }

    public function renderAnalysisStatus($status, $color = false)
    {
        $status = $this->getAnalysisStatus($status);
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