<?php

namespace Waxis\Cms\Cms\Module;

class Content {

	public static function convertToDb ($data) {
		$return = $data;

		foreach (config('locale.languages') as $iso => $lang) {
			$return[$iso] = preg_replace( "/\r|\n/", "", nl2br($return[$iso]));
		}
		
		return $return;
	}

	public static function convertToForm ($data) {
		$return = $data;

		foreach (config('locale.languages') as $iso => $lang) {
			$return[$iso] = br2nl($return[$iso]);
		}

		return $return;
	}

	public function extendDescriptor (&$cms) {
		$module = $cms->descriptor['module'];
		$options = getValue($module, 'options', []);

		$table = str_replace('-', '_', $cms->tab);
		if (isset($options['table'])) {
			$table = $options['table'];
		}

		$file = str_replace('_','-',str_replace('-contents', '', $cms->tab));
		if (isset($options['file'])) {
			$file = $options['file'];
		}

		$cms->descriptor['table'] = $table;
		$cms->descriptor['file'] = $file;
		$cms->descriptor['actions'] = ['edit'];

		$elements = [
			[
				'name' => 'tag',
				'label' => 'cms.translation.tag_label',
				'viewMode' => true,
			],
			[
				'type' => 'hidden',
				'name' => 'tag',
			]
		];

		foreach (config('locale.languages') as $one) {
			$elements[] = [
				'type' => 'textarea',
				'name' => $one['iso2'],
				'label' => $one['name'],
				'required' => true,
			];

			$filterFields[] = $one['iso2'];
		}

		$cms->descriptor['form'] = [
			'descriptor' => [
				'id' => $cms->tab . '-form',
				'before' => [
					[
						'class' => '\Waxis\Cms\Cms\Module\Content',
						'method' => 'convertToDb',
						'updateData' => true,
					]
				],
				'after' => [
					[
						'class' => '\Waxis\Cms\Cms\Module\Content',
						'method' => 'createFileFromDb',
						'params' => [
							'table' => $table
						]
					]
				],
				'converters' => ['\Waxis\Cms\Cms\Module\Content::convertToForm'],
				'elements' => $elements
			]
		];

		$fields = [];

		$fields[] = [
			'label' => 'cms.translation.tag_label',
			'name' => 'tag',
			'clickable' => true,
		];

		$filterFields = ['tag'];

		foreach (config('locale.languages') as $one) {
			$fields[] = [
				'label' => $one['name'],
				'name' => $one['iso2'],
			];

			$filterFields[] = $one['iso2'];
		}

		$cms->descriptor['list'] = [
			'descriptor' => [
				'id' => $cms->tab,
				'limit' => 100,
				'fields' => $fields
			],
			'filters' => [
				[
					'name' => 'search',
					'placeholder' => trans('cms.translation.filter_search'),
					'fields' => $filterFields
				],
			],
			'buttons' => [
				[
					'class' => 'btn-primary btn-import-content',
					'label' => trans('cms.translation.btn_refresh_list'),
					'url' => '/admin/%tab/import-content',
				]
			]
		];

		unset($cms->descriptor['module']);
	}

	# importálni mielőtt exportálunk
	public static function createFileFromDb($data, $params)
	{
		$table = $params['table'];
		$fileName = str_replace('_','-',str_replace('_contents', '', $table));

		if (!\Waxis\Cms\Cms\Module\Content::import($table, $fileName)) {
			return false;
		}

		$languages = config('locale.languages');

		$tags = to_array(\DB::table($table)->orderBy('created_at', 'ASC')->get());

		try {
			foreach ($languages as $iso => $language) {
				$content = '<?php' . PHP_EOL;
				$content .= '' . PHP_EOL;
				$content .= 'return [' . PHP_EOL;

				foreach ($tags as $tag) {
					$content .= "	'".$tag['tag']."' => '".addslashes($tag[$iso])."',". PHP_EOL;
				}

				$content .= '];';

				$file = resource_path('lang/' . $iso . '/' . $fileName . '.php');

				$contents[$iso] = [
					'file' => $file,
					'content' => $content
				];
			}
			
		} catch (\Exception $e) {
			return false;
		}

		foreach ($contents as $content) {
			file_put_contents($content['file'], $content['content']);	
		}

		return true;
	}

	public static function import ($table, $fileName) {
		$tags = to_array(\DB::table($table)->get());

		$temp = [];
		foreach ($tags as $tag) {
			$temp[$tag['tag']] = true;
		}
		$tags = $temp;

		$import = [];

		$languages = config('locale.languages');

		try {
			foreach ($languages as $iso => $language) {
				$file = resource_path('lang/' . $iso . '/' . $fileName . '.php');

				$fh = fopen($file,'r');
				while ($line = fgets($fh)) {
					$line =  trim(preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $line));

					if (strstr($line, '=>')) {
						$parts = explode('=>', $line);
						$tag = trim(trim(trim($parts[0]),","),"'");
						$expression = trim(trim(trim($parts[1]),","),"'");

						if (!isset($tags[$tag])) {
							$import[$tag]['tag'] = $tag;
							$import[$tag][$iso] = $expression;
							$import[$tag]['created_at'] = date('Y-m-d H:i:s');
							$import[$tag]['updated_at'] = date('Y-m-d H:i:s');
						}
					}

				}
				fclose($fh);
			}

			if (!empty($import)) {
				\DB::table($table)->insert($import);
			}
		} catch (\Exception $e) {
			//DX($e->getMessage());
			return false;
		}

		return true;
	}
}