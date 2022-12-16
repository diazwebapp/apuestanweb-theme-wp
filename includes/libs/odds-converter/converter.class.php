<?php

class Converter {

    private $iOddsFromUser;
    private $sUserOddsType;

    public function __construct($iOddsFromUser, $sUserOddsType) {
        $custom_cuote = str_replace(",",".",$iOddsFromUser);
        $this->iOddsFromUser = $custom_cuote;
        $this->sUserOddsType = $sUserOddsType;
    }

    public function doConverting() {

        switch ($this->sUserOddsType) {
            case "uk":
                $iDecimal = $this->convertDecimalFromFraction($this->iOddsFromUser);
                break;
            case "eu":
                $iDecimal = floatval($this->iOddsFromUser);
                break;
            case "usa":
                $iDecimal = $this->convertDecimalFromUs($this->iOddsFromUser);
                break;
        }
        
        $aResult = array();
        if (is_numeric($iDecimal) ) {
            $aResult[0] = "ok";
            $aResult[1] = $this->convertFractionalFromDecimal($iDecimal);
            $aResult[2] = round(($iDecimal * 100 ) / 100,3);
            $aResult[3] = $this->convertUsFromDecimal($iDecimal);
        }
        
        return $aResult;
    }

    public function convertDecimalFromFraction($sFraction) {
        if($sFraction == 1): 
            return $sFraction;
        endif;
        $aNumbers = explode("/", $sFraction);
        if (count($aNumbers) == 2 && is_numeric($aNumbers[0]) && is_numeric($aNumbers[1])) {
            return ($aNumbers[0] / $aNumbers[1]) + 1;
        }
    }

    public function convertDecimalFromUs($iDecimal) {
        /* if($iDecimal == 1): 
            return $iDecimal;
        endif; */
        if ($iDecimal > 0) {
            return ($iDecimal / 100) + 1;
        } else {
            return (100 / $iDecimal * -1) + 1;
        }
    }

    public function convertUsFromDecimal($iDecimal) {
        //a > 0 ? a / 100 + 1 : 100 / a * -1 + 1
        $iDecimal -= 1;
        if($iDecimal < 1){
            return "-" .  round(($iDecimal + 100/$iDecimal -1) * 10,2) ;
        }else{
            return "+" . round(($iDecimal + 100 * $iDecimal),3) ;
        }
        /* if ($iDecimal < 1) {
            return '+' . abs(round(100 / $iDecimal));
        } else {
            return '-' . round(($iDecimal * 100),3);
        } */
    }

    public function convertFractionalFromDecimal($iDecimal) {
        
        $iDecimal = round(floatval($iDecimal),3);
        $iNumber = round(($iDecimal - 1) * 10000);
        $iDom = round(10000);

        $aReduced = $this->reduce($iNumber, $iDom);
        $iNumber = $aReduced[0];
        $iDom = $aReduced[1];

        return $iNumber . '/' . $iDom;
    }

    public function reduce($iNumber, $iDom) {
        $aReduced = array();
        $iGcd = $this->GcdCalculator($iNumber, $iDom);
        $aReduced[0] = $iNumber / $iGcd;
        $aReduced[1] = $iDom / $iGcd;
        return $aReduced;
    }

    public function GcdCalculator($iNumber1, $iNumber2) {
        return ($iNumber1 % $iNumber2) ? $this->GcdCalculator($iNumber2, $iNumber1 % $iNumber2) : $iNumber2;
    }

}
