<?php
class Wufoox
{
	public $modx;

	public $config = array();

	public $cache;

	public function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$basePath = $this->modx->getOption('wufoox.core_path', $config, $this->modx->getOption('core_path') . 'components/wufoox/');
		$assetsUrl = $this->modx->getOption('wufoox.assets_url', $config, $this->modx->getOption('assets_url') . 'components/wufoox/');
		$this->config = array_merge(array(
			'basePath' => $basePath,
			'corePath' => $basePath,
			'modelPath' => $basePath . 'model/',
			'chunksPath' => $basePath . 'elements/chunks/',
			'jsUrl' => $assetsUrl . 'js/',
			'cssUrl' => $assetsUrl . 'css/',
			'assetsUrl' => $assetsUrl,
		), $config);

		$this->modx->addPackage('wufoox', $this->config['modelPath']);
	}

	public function getChunk($name, $properties = array()) {
		$chunk = null;
		if (!isset($this->chunks[$name])) {
			$chunk = $this->modx->getObject('modChunk', array('name' => $name));
			if (empty($chunk)) {
				$chunk = $this->_getTplChunk($name);
				if ($chunk == false) return false;
			}
			$this->chunks[$name] = $chunk->getContent();
		} else {
			$o = $this->chunks[$name];
			$chunk = $this->modx->newObject('modChunk');
			$chunk->setContent($o);
		}
		$chunk->setCacheable(false);
		return $chunk->process($properties);
	}

	private function _getTplChunk($name, $postfix = '.chunk.tpl') {
		$chunk = false;
		$f = $this->config['chunksPath'].strtolower($name).$postfix;
		if (file_exists($f)) {
			$o = file_get_contents($f);
			$chunk = $this->modx->newObject('modChunk');
			$chunk->set('name', $name);
			$chunk->setContent($o);
		}
		return $chunk;
	}
}
