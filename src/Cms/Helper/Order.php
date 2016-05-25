<?php

namespace Waxis\Cms\Cms\Helper;

class Order {

	public function correctOrder ($data, $params = array()) {
		if ($params['params'] === null || empty($data[$params['idField']])) {
			return;
		}

		$table = $params['table'];
		$orderField = $params['orderField'];
		$id = $data[$params['idElement']];

		# @todo: check
		$result = collect(\DB::table($table)->where($params['idField'], '=', $id)->first())->toArray();

		$searchParamsChanged = false;
		foreach ($params['params'] as $param) {
			if ($data[$param] != $result[$param]) {
				$searchParamsChanged = true;
			}
		}
		if (!$searchParamsChanged) {
			return;
		}

		$descriptor = array(
			$table => array(
				'table' => $table,
				'orderColumn' => $orderField
			)
		);

		# @todo: check
		$order = new \Order($table);
		$order->setDescriptor($descriptor);

		$searchParams = array();

		foreach ($params['params'] as $param) {
			$searchParams[$param] = $result[$param];
		}

		$order->setSearchParams($searchParams);

		$order->removeOrder($id);

		$searchParams = array();

		foreach ($params['params'] as $param) {
			$searchParams[$param] = $data[$param];
		}

		$order->setSearchParams($searchParams);

		$nextOrder = $order->getNextOrder();

		$connector = false;
		if (isset($result['connector'])) {
			$connector = $result['connector'];
		}

		$where = $params['idField'] . ' = ' . $data[$params['idElement']];

		if ($connector) {
			$where = "connector = $connector";
		}

		\DB::table($table)->whereRaw($where)->update(array($orderField => $nextOrder));
	}

	public function addOrder ($data, $params = array()) {
		$table = $params['table'];
		$orderField = $params['orderField'];
		
		# @todo: check
		$record = collect(\DB::table($table)->where($params['idField'], '=', $data[$params['idElement']])->first())->toArray();

		$collection = false;
		if (isset($record['language']) && isset($record['connector'])) {
			$collection = true;
		}

		if (!empty($record[$orderField])) {
			return;
		}

		$descriptor = array(
			$table => array(
				'table' => $table,
				'orderColumn' => $orderField
			)
		);

		# @todo: check
		$order = new \Order($table);
		$order->setDescriptor($descriptor);

		if ($params['params'] !== null) {
			$searchParams = array();

			foreach ($params['params'] as $param) {
				$searchParams[$param] = $data[$param];
			}

			$order->setSearchParams($searchParams);
		}

		$nextOrder = $order->getNextOrder();
		
		# @todo: check
		$update = \DB::table($table);

		if ($collection) {
			$update->where('connector', $record['connector']);
		} else {
			$update->where($params['idField'], $data[$params['idElement']]);
		}

		$update->update(array($orderField => $nextOrder));
	}
}