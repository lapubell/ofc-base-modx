<?php

// this assumes the repo is inside $httpdocs/assets/repo, adjust the path below if necessary
require_once '../../../config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('web');

$modx->cacheManager->refresh();