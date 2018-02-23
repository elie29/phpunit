<?php

use Doctrine\Common\Cache\FilesystemCache;

return new FilesystemCache(BE_PATH . '/cache');