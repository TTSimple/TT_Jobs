<?php

namespace Core\Component\Version;


abstract class ARegister
{
    abstract function register(VersionList $versionList);
}