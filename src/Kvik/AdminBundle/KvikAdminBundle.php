<?php

namespace Kvik\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KvikAdminBundle extends Bundle
{
	public function getParent() {
		return 'FOSUserBundle';
	}
}
