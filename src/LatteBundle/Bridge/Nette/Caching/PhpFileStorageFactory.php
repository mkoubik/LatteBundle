<?php

namespace Lattebundle\Bridge\Nette\Caching;

use Nette\Caching as NCaching;

class PhpFileStorageFactory
{
	public function create($cacheDir)
	{
		if (@mkdir($cacheDir, 0777, true) === false && !is_dir($cacheDir)) {
			throw new \RuntimeException(sprintf("Unable to create the cache directory (%s).", $cacheDir));
		}
		$journal = new NCaching\Storages\FileJournal($cacheDir);
		$storage = new NCaching\Storages\PhpFileStorage($cacheDir, $journal);
		return $storage;
	}
}
