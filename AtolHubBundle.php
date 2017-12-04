<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle;

use AmaxLab\Oro\Bundle\AtolHubBundle\DependencyInjection\AtolHubBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class AtolHubBundle extends Bundle
{
    /**
     * @return AtolHubBundleExtension
     */
    public function getContainerExtension()
    {
        if (!$this->extension) {
            $this->extension = new AtolHubBundleExtension();
        }

        return $this->extension;
    }
}
