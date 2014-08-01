<?php

namespace Viktis\Bundle\WebBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ViktisWebBundle extends Bundle
{
    public function getParent()
    {
        return 'SyliusWebBundle';
    }
}
