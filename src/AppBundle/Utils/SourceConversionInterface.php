<?php

namespace AppBundle\Utils;

interface SourceConversionInterface {

    public function getShortName();

    public function getDecimal();

    public function getPoint();

    public function getThousandsSep();

    public function getRoundMode();

}