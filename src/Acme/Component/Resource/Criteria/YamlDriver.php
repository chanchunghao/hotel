<?php

namespace Acme\Component\Resource\Criteria;

use Symfony\Component\Yaml\Yaml;

class YamlDriver extends AbstractDriver
{
    /**
     * @param string $path
     * @return array
     */
    protected function parseMappingFile($path)
    {
        return Yaml::parse($path);
    }
}
