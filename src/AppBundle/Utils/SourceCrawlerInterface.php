<?php

namespace AppBundle\Utils;

interface SourceCrawlerInterface
{
    public function getShortName();

    public function getRemoteUrl();

    public function getLongName();

    public function getDecimal();

    public function getPoint();

    public function getThousandsSep();

    public function getRoundMode();

    public function getElements();
}