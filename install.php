<?php
/**
 * Part of CodeIgniter Twig & HMVC
 *
 * @author     Andi Kurniawan <https://github.com/adxio>
 * @license    MIT License
 * @copyright  2019 Andi kurniawan
 * @link       https://github.com/adxio/twig-hmvc
 */

$installer = new Installer();
$installer->install();

class Installer
{
	public static function install()
	{
		self::copy('vendor/adxio/twig-hmvc/Twig.php', 'application/libraries/Twig.php');
		self::recursiveCopy('vendor/adxio/twig-hmvc/config', 'application/config');
		self::recursiveCopy('vendor/adxio/twig-hmvc/modules', 'application/modules');
		self::recursiveCopy('vendor/adxio/twig-hmvc/hmvc/MX', 'application/third_party/MX');
		self::copy('vendor/adxio/twig-hmvc/hmvc/MY_Router.php', 'application/core/MY_Router.php');
		self::copy('vendor/adxio/twig-hmvc/hmvc/MY_Loader.php', 'application/core/MY_Loader.php');
		echo 'Installation Done'.PHP_EOL;
	}

	private static function copy($src, $dst)
	{
		$success = copy($src, $dst);
		if ($success) {
			echo 'copied: ' . $dst . PHP_EOL;
		}
	}

	/**
	 * Recursive Copy
	 *
	 * @param string $src
	 * @param string $dst
	 */
	private static function recursiveCopy($src, $dst)
	{
		@mkdir($dst, 0755);
		
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::SELF_FIRST
		);
		
		foreach ($iterator as $file) {
			if ($file->isDir()) {
				@mkdir($dst . '/' . $iterator->getSubPathName());
			} else {
				if($iterator->getSubPathName() != 'composer.json') {
					$success = copy($file, $dst . '/' . $iterator->getSubPathName());
					if ($success) {
						echo 'copied: ' . $dst . '/' . $iterator->getSubPathName() . PHP_EOL;
					}
				}
			}
		}
	}
}
