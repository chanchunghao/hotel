<?php

namespace Acme\Bundle\CoreBundle;

use Acme\Bundle\CoreBundle\DependencyInjection\ValidatorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ValidatorCompilerPass());
    }
}
