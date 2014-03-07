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

class ComRedisModelDefault extends ComDefaultModelDefault
{
	public $redis;

	/**
	 * @param KConfig $config
	 */
	public function __construct(KConfig $config)
	{
		parent::__construct($config);

		$this->redis = new Predis\Client([
			'scheme' => 'tcp',
			'host'   => '127.0.0.1',
			'port'   => 6379,
		]);

		$this->_state
			->insert('cache',	'int', 1)
		;
	}

	public function getItem()
	{
		$state = $this->_state;

		if($state->cache === 0 || !$state->id) {
			parent::getItem();
		} else {
			$state = $this->_state;

			$row = array_merge(unserialize($this->redis->get('event:'.$state->id)), array('cached' => 1));

			$this->_item = $this->getTable()->getRow(array('data' => $row, 'new' => false));
		}

		return $this->_item;
	}

	public function getList()
	{
		$state = $this->_state;

		$filter = $this->getService('koowa:filter.slug');

//		$this->redis->flushall();
//
//		$this->_state->limit = 100;
//
//		parent::getList();
//
//
//		foreach($this->_list as $key => $row) {
//			$this->redis->set('event:'.$key, serialize($row->toArray()));
//			$this->redis->rpush('events', $key);
//			$this->redis->sadd('ctas_involvement:'. $filter->sanitize($row->ctas_involvement), $key);
//		}

		if($state->search) {
			parent::getList();
		} else {
			if($state->ctas_involvement) {
				$list = $this->redis->smembers('ctas_involvement:'.$filter->sanitize($state->ctas_involvement));
			} else {
				$list = $this->redis->lrange('events', 0, 19);
			}

			foreach($list as $item) {
				$rows[] = array_merge(unserialize($this->redis->get('event:'.$item)), array('cached' => 1));
			}

			$this->_list = $this->getTable()->getRowset()->addData($rows, false);
		}

		return $this->_list;
	}
}