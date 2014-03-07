<?php
/**
 * Com
 *
 * @author      Dave Li <dave@moyoweb.nl>
 * @category    Nooku
 * @package     Socialhub
 * @subpackage  ...
 * @uses        Com_
 */
 
defined('KOOWA') or die('Protected resource');

require 'vendor/autoload.php';
Predis\Autoloader::register();

class ComRedisDatabaseBehaviorCacheable extends KDatabaseBehaviorAbstract
{
	protected $_redis;

	/**
	 * @param KConfig $config
	 */
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'priority'   => KCommand::PRIORITY_LOWEST,
		));

		parent::_initialize($config);
	}

	protected function _getRedis()
	{
		$this->_redis = new Predis\Client([
			'scheme' => 'tcp',
			'host'   => '127.0.0.1',
			'port'   => 6379,
		]);

		return $this->_redis;
	}

	/**
	 * @param KCommandContext $context
	 */
	protected function _afterTableInsert(KCommandContext $context)
	{
		$this->_saveCache($context);
	}

	/**
	 * @param KCommandContext $context
	 */
	protected function _afterTableUpdate(KCommandContext $context)
	{
		$this->_saveCache($context);
	}

	/**
	 * @param $context
	 */
	protected function _saveCache($context)
	{
		if($context->data->getModified()) {
			$redis = $this->_getRedis();

			$identifier = clone $context->caller->getIdentifier();
			$identifier->path = array('model');

			$row = $this->getService($identifier)->id($context->data->id)->cache(0)->getItem();

			$filter = $this->getService('koowa:filter.slug');

			$redis->set(KInflector::singularize($identifier->name).':'.$row->id, serialize($row->toArray()));
			$redis->lpush(KInflector::pluralize($identifier->name), $row->id);
			$redis->sadd('ctas_involvement:'. $filter->sanitize($row->ctas_involvement), $row->id);
		}
	}
}