<?php

namespace AppBundle\Utils;

interface SourceCrawlerInterface
{
    public function getShortName();

    public function getBaseCurrency();

    public function getRemoteUrl();

    public function getLongName();

    public function getElements();
}
