<?php
// Bootstrap for PHPStan: load Yii and provide minimal stubs for classes PHPStan can't discover.
@require_once __DIR__ . '/../framework/yii.php';

// Define minimal stubs only if they don't already exist.
if (!class_exists('CComponent')) {
	class CComponent {}
}

if (!class_exists('CController')) {
	class CController extends CComponent {
		public array $menu = [];
		public array $breadcrumbs = [];
		public function render($view, $data = []): void {}
		public function redirect($url): void {}
		public function widget($name, $config = []): void {}
		public function renderPartial($view, $data = []): void {}
		/**
		 * @param string $class
		 * @param mixed $config
		 * @return CActiveFormWidget|object
		 */
		public function beginWidget($class, $config = []) {
			if ($class === 'CActiveForm' || $class === 'CActiveFormWidget') {
				return new CActiveFormWidget();
			}
			return new stdClass();
		}
		public function endWidget(): void {}
	}
}

if (!class_exists('CButtonColumn')) {
	class CButtonColumn {
		/** @var string */
		public $template;
		/** @var array */
		public $buttons = [];
		/** @var array */
		public $visibleButtons = [];
		/** @var string */
		public $header;
	}
}

if (!class_exists('CApplication')) {
	class CApplication extends CComponent {
		public $request;
		public $user;
		public $homeUrl;
		public $errorHandler;
	}
}

if (!class_exists('CWebApplication')) {
	class CWebApplication extends CApplication {
		public $name;
		public function run(): void {}
		public function end(int $status = 0): void {}
	}
}

if (!class_exists('CUserIdentity')) {
	class CUserIdentity {
		public ?string $username = null;
		public ?string $password = null;
		public ?int $errorCode = null;
		public const ERROR_NONE = 0;
		public const ERROR_USERNAME_INVALID = 1;
		public const ERROR_PASSWORD_INVALID = 2;
	}
}

if (!class_exists('CWebUser')) {
	class CWebUser {
		public $name;
		public function setState(string $key, $value): void {}
	}
}

if (!class_exists('CFormModel')) {
	class CFormModel extends CComponent {}
}

if (!class_exists('CActiveRecord')) {
	class CActiveRecord extends CComponent {
		public const BELONGS_TO = 1;
		public const HAS_MANY = 2;
		public const MANY_MANY = 3;
		public const HAS_ONE = 4;

		public array $attributes = [];
		public $id;
		public bool $isNewRecord = false;

		public function save(): bool { return true; }
		public function delete(): bool { return true; }
		public static function model($className = null) {}
		public static function find($condition = '', $params = []) {}
		public static function findByPk($pk) {}
		public function unsetAttributes($values = null): void {}
		public function getAttributeLabel($attr): string { return $attr; }
		public function search() {}
	}
}

if (!class_exists('CActiveDataProvider')) {
	class CActiveDataProvider {
		public function __construct($modelClass, $config = []) {}
	}
}

if (!class_exists('CDbCriteria')) {
	class CDbCriteria {
		public function addSearchCondition($column, $keyword, $partialMatch = false) {}
	}
}

if (!class_exists('CActiveForm')) {
	class CActiveForm {
		public static function validate($model) { return ''; }
	}
}

if (!class_exists('CActiveFormWidget')) {
	class CActiveFormWidget {
		public function errorSummary($model): string { return ''; }
		public function labelEx($model, $attribute): string { return ''; }
		public function textField($model, $attribute, $options = []): string { return ''; }
		public function passwordField($model, $attribute, $options = []): string { return ''; }
		public function checkBox($model, $attribute, $options = []): string { return ''; }
		public function label($model, $attribute = null, $options = []): string { return ''; }
		public function error($model, $attribute): string { return ''; }
	}
}

if (!class_exists('Controller')) {
	class Controller extends CController {
		public $pageTitle;
		public function beginContent($view = null, $data = []) {}
		public function endContent() {}
		public function getLayoutFile($name) { return ''; }
	}
}

if (!class_exists('CHtml')) {
	class CHtml {
		public static function encode($text) { return (string)$text; }
		public static function link($text, $url = []) { return (string)$text; }
		public static function submitButton($label) { return (string)$label; }
		public static function beginForm($action = '', $method = 'post', $options = []) { return ''; }
		public static function endForm() { return ''; }
		public static function label($label, $for) { return (string)$label; }
		public static function textField($name, $value = '', $htmlOptions = []) { return (string)$value; }
		public static function linkButton(...$args) { return ''; }
	}
}

if (!class_exists('CDbMigration')) {
	class CDbMigration {
		public function createTable(string $name, array $columns): void {}
		public function dropTable(string $name): void {}
		public function insert(string $table, array $data): void {}
		public function delete(string $table, $condition = '', array $params = []): void {}
		public function addPrimaryKey(string $name, string $table, string $columns): void {}
		public function createIndex(string $name, string $table, string $columns, bool $unique = false): void {}
		public function addForeignKey(string $name, string $table, string $column, string $refTable, string $refColumn, $onDelete = null, $onUpdate = null): void {}
		public function dropForeignKey(string $name, string $table): void {}
		
		public function dropIndex(string $name, string $table): void {}
		public function createCommand() {}
	}
}

if (!class_exists('CDbExpression')) {
	class CDbExpression {
		public function __construct($expression) {}
	}
}

if (!class_exists('CHttpException')) {
	class CHttpException extends \Exception {
		public function __construct(int $status, string $message = '') {}
	}
}

// Make Yii::app() available for static analysis if missing.
if (!class_exists('Yii')) {
	class Yii {
		public static function app(): CWebApplication {
			static $app;
			if ($app === null) {
				$app = new CWebApplication();
				$app->user = new CWebUser();
			}
			return $app;
		}

		public static function createWebApplication($config = null): CWebApplication
		{
			return new CWebApplication();
		}

		public static function powered(): string
		{
			return 'Yii Framework';
		}
	}
}

